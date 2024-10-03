<template>
  <div v-if="isApply" class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center space-x-4 mb-4">
      <img :src="photoUrl" alt="Фото" class="w-24 h-24 rounded-full object-cover" />
      <div>
        <h1 class="text-3xl font-bold">{{ fullName }}</h1>
        <p class="text-gray-600">{{ profession }}</p>
      </div>
    </div>
    <div class="mb-4">
      <p class="text-gray-700"><strong>Город:</strong> {{ city }}</p>
      <p class="text-gray-700"><strong>Телефон:</strong> {{ phone }}</p>
      <p class="text-gray-700"><strong>Email:</strong> {{ email }}</p>
      <p class="text-gray-700"><strong>Дата рождения:</strong> {{ birthDate }}</p>
      <p class="text-gray-700"><strong>Образование:</strong> {{ educationLabel }}</p>
      <div
        class="flex flex-col gap-2 pl-2 pt-2"
        v-if="
          education === `colledge` || education === `not_university` || education === `university`
        "
      >
        <p class="text-gray-600"><strong>Учебное заведение:</strong> {{ stateUnivesity }}</p>
        <p class="text-gray-600"><strong>Факультет:</strong> {{ faculty }}</p>
        <p class="text-gray-600"><strong>Специализация:</strong> {{ spec }}</p>
        <p class="text-gray-600"><strong>Год окончания:</strong> {{ year_finish }}</p>
      </div>
      <div v-for="(edu, index) in additionalEducation" :key="index" class="flex flex-col pl-2 pt-2">
        <p class="text-gray-600">
          <strong>Ссылка на {{ index + 1 }} доп образование:</strong> {{ edu[index] }}
        </p>
      </div>
      <p class="text-gray-700 mt-2"><strong>Желаемая зарплата:</strong> {{ desiredSalary }}</p>
    </div>
    <div class="mb-4">
      <h2 class="text-xl font-semibold mb-2">Ключевые навыки</h2>
      <p class="text-gray-700">{{ skills }}</p>
    </div>
    <div>
      <h2 class="text-xl font-semibold mb-2">О себе</h2>
      <p class="text-gray-700">{{ about }}</p>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  isApply: Boolean,
  photoUrl: String,
  stateUnivesity: String,
  faculty: String,
  spec: String,
  year_finish: String,
  fullName: String,
  profession: String,
  city: String,
  phone: String,
  email: String,
  birthDate: String,
  educationLabel: String,
  education: String,
  desiredSalary: String,
  skills: String,
  about: String,
  additionalEducation: Array
})
</script>

<style lang="scss" scoped></style>
