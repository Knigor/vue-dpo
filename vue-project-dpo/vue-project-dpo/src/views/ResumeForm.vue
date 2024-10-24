<template>
  <div class="min-h-screen bg-gray-100 p-8">
    <!-- Форма для заполнения данных -->
    <div class="max-w-3xl mx-auto mb-10">
      <div class="flex justify-between">
        <Button @click="goToMain" class="w-24" variant="link">На главную</Button>
        <h2 class="text-2xl font-semibold mb-6">Введите данные для резюме</h2>
      </div>
      <ResumeComponent @submit="handleFormSubmit" />
    </div>

    <!-- Шаблон резюме -->
    <ResumeForm
      v-if="isSubmitted"
      :university="resumeData.university"
      :isApply="resumeData.isApply"
      :photoUrl="resumeData.photoUrl"
      :phone="resumeData.phone"
      :profession="resumeData.profession"
      :city="resumeData.city"
      :fullName="resumeData.fullName"
      :email="resumeData.email"
      :birthDate="resumeData.birthDate"
      :education="resumeData.education"
      :desiredSalary="resumeData.desiredSalary"
      :skills="resumeData.skills"
      :about="resumeData.about"
      :stateUnivesity="resumeData.selectedUniversity"
      :faculty="resumeData.faculty"
      :spec="resumeData.spec"
      :year_finish="resumeData.year_finish"
      :isUniversity="resumeData.isUniversity"
      :educationLabel="resumeData.educationLabel"
      :additionalEducation="resumeData.additionalEducation"
      :educationList="resumeData.educationList"
      class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md"
    />
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import Button from '@/components/ui/button/Button.vue'

import { useRouter, useRoute } from 'vue-router'
import ResumeForm from '../components/FormStudy.vue'

import ResumeComponent from '@/components/ResumeComponent.vue'

// логика для отправки формы
const isSubmitted = ref(false)
const resumeData = ref({})
const isApply = ref(false)
const handleFormSubmit = (formData) => {
  resumeData.value = { ...formData }
  isSubmitted.value = true
}
// Роутинг

const router = useRouter()

const goToMain = () => {
  router.push('/')
}
</script>

<style lang="scss" scoped></style>
