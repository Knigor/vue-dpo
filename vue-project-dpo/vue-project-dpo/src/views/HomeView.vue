<template>
  <div>
    <div class="flex h-screen items-center justify-center gap-6">
      <Button @click="goToTuskOne" class="w-24" variant="link">Задание №1</Button>
      <Button @click="goToTuskTwo" class="w-24" variant="link">Задание №2..</Button>
      <!-- <VkauthButton /> -->
    </div>
  </div>
</template>

<script setup>
import Button from '@/components/ui/button/Button.vue'
import { useRoute, useRouter } from 'vue-router'
import VkauthButton from '../components/VkauthButton.vue'

const router = useRouter()

const goToTuskOne = () => {
  router.push('/taskOne')
}

const goToTuskTwo = () => {
  router.push('/resumeForm')
}
</script>
