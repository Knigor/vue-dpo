import { defineStore } from 'pinia'
import { reactive } from 'vue'

export const useSceneStore = defineStore('scene', () => {
  const scene = reactive({
    children: [],
    typeResume: [
      { id: 1, status: 'Новый' },
      { id: 2, status: 'Назначено собеседование' },
      { id: 3, status: 'Принят' },
      { id: 4, status: 'Отказ' }
    ],
    status: 'loading'
  })

  const loadSceneData = async () => {
    try {
      const response = await fetch('http://localhost:8080/api/cv')
      if (!response.ok) throw new Error('Ошибка сети')
      const data = await response.json()
      scene.status = 'complete'
      scene.children = data.map((item) => ({
        id: item.id,
        name: item.name,
        profession: item.profession,
        age: item.age,
        status: item.status
      }))
    } catch (error) {
      scene.status = 'failed'
      console.error('Ошибка при загрузке данных:', error)
    }
  }

  return { scene, loadSceneData }
})
