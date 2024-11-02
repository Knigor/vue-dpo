// store/sceneStore.js
import { defineStore } from 'pinia'
import { reactive } from 'vue'

export const useSceneStore = defineStore('scene', () => {
  const scene = reactive({
    children: [],
    status: 'loading'
  })

  // Функция для загрузки данных из API
  const loadSceneData = async () => {
    try {
      const response = await fetch('http://localhost:8080/api/cv')
      if (!response.ok) {
        throw new Error('Ошибка сети')
      }
      const data = await response.json()
      // Предполагается, что ваша API возвращает данные в нужной структуре
      scene.status = 'complete'
      console.log(data)
    } catch (error) {
      scene.status = 'failed'
      console.error('Ошибка при загрузке данных:', error)
    }
  }

  const onColumnDrop = (dropResult) => {
    scene.children = applyDrag(scene.children, dropResult)
  }

  const onCardDrop = (columnId, dropResult) => {
    const column = scene.children.find((p) => p.id === columnId)
    if (column) {
      column.children = applyDrag(column.children, dropResult)
    }
  }

  const getCardPayload = (columnId) => (index) => {
    const column = scene.children.find((p) => p.id === columnId)
    return column ? column.children[index] : null
  }

  const dragStart = () => {
    console.log('drag started')
  }

  const log = (...params) => {
    console.log(...params)
  }

  // Вызываем функцию загрузки данных при создании хранилища
  loadSceneData()

  return { scene, onColumnDrop, onCardDrop, getCardPayload, dragStart, log }
})

// Функция для перемещения элементов
function applyDrag(arr, dragResult) {
  const { removedIndex, addedIndex, payload } = dragResult
  if (removedIndex !== null) arr.splice(removedIndex, 1)
  if (addedIndex !== null) arr.splice(addedIndex, 0, payload)
  return arr
}
