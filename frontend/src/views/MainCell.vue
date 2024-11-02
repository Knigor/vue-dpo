<template>
  <div>
    <div class="flex" v-if="scene.status === 'loading'">
      <p>Загрузка...</p>
      <!-- Лоадер -->
    </div>

    <div v-else-if="scene.status === 'failed'">
      <p>Ошибка загрузки данных</p>
    </div>

    <div v-else-if="scene.status === 'complete'">
      <p>Загрузилось</p>
      <Container
        orientation="horizontal"
        @drop="onColumnDrop($event)"
        drag-handle-selector=".column-drag-handle"
        @drag-start="dragStart"
        :drop-placeholder="upperDropPlaceholderOptions"
      >
        <Draggable v-for="column in scene.data" :key="column.id">
          <div :class="column.props.className">
            <div class="card-column-header">
              <span class="column-drag-handle">&#x2630;</span>
              {{ column.name }}
            </div>
            <Container
              group-name="col"
              @drop="(e) => onCardDrop(column.id, e)"
              @drag-start="(e) => log('drag start', e)"
              @drag-end="(e) => log('drag end', e)"
              :get-child-payload="getCardPayload(column.id)"
              drag-class="card-ghost"
              drop-class="card-ghost-drop"
              :drop-placeholder="dropPlaceholderOptions"
            >
              <Draggable v-for="card in column.children" :key="card.id">
                <div :class="card.props.className" :style="card.props.style">
                  <h3>Task # {{ card.number }}</h3>
                  <p class="card-text">{{ card.data }}</p>
                </div>
              </Draggable>
            </Container>
          </div>
        </Draggable>
      </Container>
    </div>
  </div>
</template>

<script>
import { Container, Draggable } from 'vue-dndrop'
import { useSceneStore } from '@/stores/sceneStore'

const data = [
  {
    id: 1,
    name: 'Новый',
    value: 0
  },
  {
    id: 2,
    name: 'Назначено собеседование',
    value: 0
  },
  {
    id: 3,
    name: 'Принят',
    value: 0
  },
  {
    id: 4,
    name: 'Отказ',
    value: 0
  }
]

export default {
  name: 'CardContainer',

  components: { Container, Draggable },

  setup() {
    const sceneStore = useSceneStore()
    const { scene, onColumnDrop, onCardDrop, getCardPayload, dragStart, log } = sceneStore

    console.log(scene.status)

    return {
      scene,
      onColumnDrop,
      onCardDrop,
      getCardPayload,
      dragStart,
      log,
      upperDropPlaceholderOptions: {
        className: 'cards-drop-preview',
        animationDuration: '150',
        showOnTop: true
      },
      dropPlaceholderOptions: {
        className: 'drop-preview',
        animationDuration: '150',
        showOnTop: true
      }
    }
  }
}
</script>
