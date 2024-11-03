<template>
  <div class="flex flex-wrap gap-4 h-[600px]">
    <div v-for="(list, key) in resume" :key="key" class="col-3">
      <h3>{{ key }}</h3>
      <draggable class="list-group" v-model="resume[key]" group="people" @change="log" itemKey="id">
        <template #item="{ element, index }">
          <div class="list-group-item cursor-pointer">{{ element.name }} {{ index }}</div>
        </template>
      </draggable>
    </div>

    <rawDisplayer class="col-3" :value="resume.list1" title="List 1" />
    <rawDisplayer class="col-3" :value="resume.list2" title="List 2" />
  </div>
</template>

<script>
import { useSceneStore } from '@/stores/sceneStore'
import draggable from 'vuedraggable' // Убедитесь, что путь правильный

export default {
  name: 'two-lists',
  components: {
    draggable
  },
  data() {
    return {
      resume: {
        list1: [
          { name: 'John', id: 1 },
          { name: 'Joao', id: 2 },
          { name: 'Jean', id: 3 },
          { name: 'Gerard', id: 4 }
        ],
        list2: [
          { name: 'Juan', id: 5 },
          { name: 'Edgard', id: 6 },
          { name: 'Johnson', id: 7 }
        ]
      }
    }
  },
  methods: {
    log(evt) {
      console.log('List updated:', evt)
    }
  }
}
</script>

<style scoped>
.list-group {
  border: 1px solid #ccc;
  padding: 10px;
}
.list-group-item {
  padding: 5px;
  border: 1px solid #007bff;
  margin: 5px 0;
}
</style>
