import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import TaskOne from '@/views/TaskOne.vue'
import ResumeForm from '@/views/ResumeForm.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/taskOne',
      name: 'taskOne',
      component: TaskOne
    },
    {
      path: '/resumeForm',
      name: 'resumeForm',
      component: ResumeForm
    }
  ]
})

export default router
