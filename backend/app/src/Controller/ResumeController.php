<?php

declare(strict_types=1);

namespace App\Controller;

use App\Document\Resume;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResumeController extends AbstractController
{
    private DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    #[Route('/api/cv', name: 'cv_index', methods: ['GET'])]
    public function index(): Response
    {
        $resumeRepository = $this->dm->getRepository(Resume::class);
        $resumes = $resumeRepository->findAll();
    
        // Преобразуем объекты в массивы
        $data = [];
        foreach ($resumes as $resume) {
            $data[] = [
                'id' => (string) $resume->getId(),
                'name' => $resume->getName(),
                'profession' => $resume->getProfession(),
                'age' => $resume->getAge(),
                'status' => $resume->getStatus(),
                'photo' => $resume->getPhoto(),
            ];
        }
    
        return $this->json($data);
    }

    #[Route('/api/cvID', name: 'api_cv_show', methods: ['GET'])]
    public function show(Request $request): JsonResponse
    {
        // Получаем id из GET параметров
        $id = $request->query->get('id');
    
        // Если id не передан, возвращаем ошибку
        if (!$id) {
            return new JsonResponse(['message' => 'ID is required'], Response::HTTP_BAD_REQUEST);
        }
    
        // Поиск резюме по id
        $resume = $this->dm->getRepository(Resume::class)->find($id);
    
        if (!$resume) {
            return new JsonResponse(['message' => 'Resume not found'], Response::HTTP_NOT_FOUND);
        }
    
        // Возвращаем данные резюме в формате JSON
        return $this->json([
            'id' => (string)$resume->getId(),
            'name' => $resume->getName(),
            'profession' => $resume->getProfession(),
            'status' => $resume->getStatus(),
        ]);
    }
    

    #[Route('/api/cv/add', name: 'api_cv_add', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        // Проверка на наличие синтаксической ошибки в JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            return new JsonResponse(['message' => 'Invalid JSON syntax'], Response::HTTP_BAD_REQUEST);
        }
    
        // Проверка на наличие обязательных полей
        if (!isset($data['name'], $data['profession'], $data['age'], $data['status'], $data['photo'])) {
            return new JsonResponse(['message' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }
    
        try {
            $resume = new Resume($data['name'], $data['profession'], $data['age'], $data['status'], $data['photo']);
            $this->dm->persist($resume);
            $this->dm->flush();
    
            return $this->json(['message' => 'Resume successfully added', 'resume' => $resume], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'Error adding resume: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    

    #[Route('/api/cv/{id}/edit', name: 'api_cv_edit', methods: ['POST'])]
    public function edit(string $id, Request $request): JsonResponse
    {
        $resume = $this->dm->getRepository(Resume::class)->find($id);
    
        if (!$resume) {
            return new JsonResponse(['message' => 'Resume not found'], Response::HTTP_NOT_FOUND);
        }
    
        $data = json_decode($request->getContent(), true);
    
        // Обновляем только те поля, которые переданы в запросе
        if (isset($data['name'])) {
            $resume->setName($data['name']);
        }
        if (isset($data['profession'])) {
            $resume->setProfession($data['profession']);
        }
        if (isset($data['age'])) {
            $resume->setAge($data['age']);
        }
        if (isset($data['status'])) {
            $resume->setStatus($data['status']);
        }
        if (isset($data['photo'])) {
            $resume->setPhoto($data['photo']);
        }
        
        $this->dm->flush();
    
        return $this->json(['message' => 'Resume successfully updated', 'resume' => $resume], Response::HTTP_ACCEPTED);
    }
    

    #[Route('/api/cv/{id}/status/update', name: 'api_cv_status_update', methods: ['POST'])]
    public function updateStatus(string $id, Request $request): JsonResponse
    {
        $resume = $this->dm->getRepository(Resume::class)->find($id);

        if (!$resume) {
            return new JsonResponse(['message' => 'Resume not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $resume->setStatus($data['status']);

        $this->dm->flush();

        return $this->json(['message' => 'Status resume updated', 'resume' => $resume], Response::HTTP_ACCEPTED);
    }
}
