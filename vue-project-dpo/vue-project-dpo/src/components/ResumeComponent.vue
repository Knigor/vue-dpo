<template>
  <div class="grid grid-cols-1 gap-4">
    <!-- Поле для ввода профессии -->
    <input v-model="profession" type="text" placeholder="Профессия" class="border p-2 rounded" />

    <!-- Поле для поиска города -->
    <div class="relative flex flex-col">
      <input
        v-model="searchQuery"
        type="text"
        :placeholder="searchQuery || 'Введите город'"
        class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
      />

      <select
        @change="handleSelectCity"
        v-if="isCityListVisible"
        id="cities"
        size="5"
        class="absolute z-10 mt-1 top-14 bg-white border border-gray-300 rounded-lg w-full max-h-60 overflow-y-auto shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
      >
        <option v-if="cities.length === 0" disabled>Ничего не найдено</option>
        <option
          v-for="city in cities"
          :key="city.id"
          :value="city.id"
          class="p-2 hover:bg-blue-100 dark:hover:bg-gray-600"
        >
          {{ city.title }}
        </option>
      </select>
    </div>

    <!-- Поле для ввода ссылки на фото -->
    <input v-model="photoUrl" type="text" placeholder="Ссылка на фото" class="border p-2 rounded" />

    <!-- Поле для ввода ФИО -->
    <input v-model="fullName" type="text" placeholder="ФИО" class="border p-2 rounded" />

    <!-- Поле для ввода телефона с валидацией -->
    <input
      @input="hasInput = true"
      v-model="phone"
      type="text"
      placeholder="Телефон"
      class="border p-2 rounded"
    />
    <p v-if="!isPhoneValid && hasInput" class="text-red-600">
      Номер телефона должен содержать только цифры и быть длиной от 6 до 10 символов
    </p>

    <!-- Поле для ввода email -->
    <input
      @input="hasEmail = true"
      v-model="email"
      type="email"
      placeholder="Email"
      class="border p-2 rounded"
    />
    <p v-if="!isEmailValid && hasEmail" class="text-red-600">Введите корректный email</p>
    <!-- Поле для выбора даты рождения -->
    <input v-model="birthDate" type="date" placeholder="Дата рождения" class="border p-2 rounded" />

    <!-- Выпадающий список для выбора уровня образования -->

    <!-- Поля для ввода учебного заведения и специальности -->
    <div>
      <div v-if="isVisibleEducation">
        <div v-for="(edu, index) in educationList" :key="index" class="flex flex-col gap-4 mt-4">
          <!-- Выпадающий список для выбора уровня образования -->
          <Select v-model="edu.educationLevel">
            <!-- Привязка к educationList -->
            <SelectTrigger>
              <SelectValue placeholder="Образование" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectLabel>Варианты уровней образования</SelectLabel>
                <SelectItem value="school"> Среднее </SelectItem>
                <SelectItem value="colledge"> Среднее специальное </SelectItem>
                <SelectItem value="not_university"> Неоконченное высшее </SelectItem>
                <SelectItem value="university"> Высшее </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>

          <div
            v-if="
              edu.educationLevel === 'university' ||
              edu.educationLevel === 'not_university' ||
              edu.educationLevel === 'colledge'
            "
            class="flex flex-col gap-4"
          >
            <div class="relative flex flex-col">
              <input
                v-model="edu.stateUnivesity"
                type="text"
                :placeholder="'Учебное заведение ' + (index + 1)"
                class="border p-2 rounded"
                @input="fetchUniversities(index)"
              />
              <select
                @change="handleSelectUniversity(index, $event)"
                v-if="edu.isVisibleUniversities"
                size="5"
                class="bg-gray-50 border z-10 top-4 border-gray-300 text-gray-900 text-sm rounded-lg"
              >
                <option v-if="edu.universities.length === 0" disabled>Ничего не найдено</option>
                <option v-for="univers in edu.universities" :key="univers.id">
                  {{ univers.title }}
                </option>
              </select>
            </div>
            <!-- Поля для ввода факультета, специальности, года окончания -->
            <input
              v-model="edu.faculty"
              type="text"
              placeholder="Факультет"
              class="border p-2 rounded"
            />
            <input
              v-model="edu.specialization"
              type="text"
              placeholder="Специализация"
              class="border p-2 rounded"
            />
            <input
              v-model="edu.year_finish"
              type="text"
              placeholder="Год окончания"
              class="border p-2 rounded"
            />
          </div>
          <!-- Поле для ввода учебного заведения -->

          <!-- Кнопка для удаления блока -->
          <button
            @click="removeEducationBlock(index)"
            class="bg-red-500 text-white px-4 py-2 rounded mt-2"
          >
            Удалить
          </button>
        </div>
      </div>
    </div>

    <button @click="addEducationBlock" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
      Добавить образование
    </button>

    <!-- Поле для ввода желаемой зарплаты -->
    <input
      v-model="desiredSalary"
      type="text"
      placeholder="Желаемая зарплата"
      class="border p-2 rounded"
    />

    <!-- Поле для ввода ключевых навыков -->
    <textarea v-model="skills" placeholder="Ключевые навыки" class="border p-2 rounded"></textarea>

    <!-- Поле для ввода информации о себе -->
    <textarea v-model="about" placeholder="О себе" class="border p-2 rounded"></textarea>

    <StatusResume />

    <!-- Дополнительное образование (добавление и удаление) -->
    <div>
      <h3 class="text-lg font-semibold mb-2">Дополнительное образование</h3>
      <div
        v-for="(edu, index) in additionalEducation"
        :key="index"
        class="flex items-center space-x-4"
      >
        <input
          v-model="edu.link"
          type="text"
          placeholder="Ссылка на сертификат"
          class="border p-2 rounded w-full"
        />
        <button @click="removeEducation(index)" class="bg-red-500 text-white px-4 py-2 rounded">
          Удалить
        </button>
      </div>
      <button @click="addEducation" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">
        Добавить образование
      </button>
    </div>

    <!-- Кнопка для применения данных -->
    <button @click="applyData" class="bg-green-500 text-white px-4 py-2 rounded mt-4">
      Применить
    </button>
  </div>
</template>

<script setup>
import { ref, computed, watch, defineEmits } from 'vue'
import StatusResume from '../components/StatusResume.vue'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue
} from '@/components/ui/select'

const profession = ref('')
const photoUrl = ref('')
const fullName = ref('')
const email = ref('')
const birthDate = ref('')
const education = ref('')
const desiredSalary = ref('')
const skills = ref('')
const about = ref('')
const hasInput = ref(false)
const hasEmail = ref(false)
const phone = ref('')
const regexPhone = /^\d{6,10}$/
const regexEmail = /^\S+@\S+\.\S+$/
const isPhoneValid = computed(() => regexPhone.test(phone.value))
const isEmailValid = computed(() => regexEmail.test(email.value))
const isApply = ref(false)
const emit = defineEmits(['submit'])
const isCityListVisible = ref(false)

const isVisibleEducation = ref(false)

const applyData = () => {
  isApply.value = true
  const formData = {
    profession: profession.value,
    city: searchQuery.value,
    photoUrl: photoUrl.value,
    fullName: fullName.value,
    phone: phone.value,
    email: email.value,
    birthDate: birthDate.value,
    education: education.value,
    desiredSalary: desiredSalary.value,
    skills: skills.value,
    about: about.value,
    additionalEducation: additionalEducation.value,
    educationList: educationList.value // Добавляем список образований
  }
  emit('submit', formData)
}

// Логика для добавления и удаления дополнительного образования
const additionalEducation = ref([])

const addEducation = () => {
  additionalEducation.value.push({ link: '' })
}

const removeEducation = (index) => {
  additionalEducation.value.splice(index, 1)
}

// Логика для динамического добавления образования
const educationList = ref([])

const addEducationBlock = () => {
  isVisibleEducation.value = true
  educationList.value.push({
    stateUnivesity: '',
    faculty: '',
    specialization: '',
    year_finish: '',
    isVisibleUniversities: false
  })
}

const removeEducationBlock = (index) => {
  educationList.value.splice(index, 1)
}

// Логика для поиска городов
const searchQuery = ref('')
const cities = ref([])
const selectedCity = ref(null)
const isVisible = computed(
  () => isCityListVisible.value && searchQuery.value.trim() !== '' && cities.value.length > 0
)

watch(searchQuery, (newValue) => {
  if (newValue.trim() !== '') {
    fetchCities()
    isCityListVisible.value = true // показать выпадающий список при вводе текста
  } else {
    cities.value = []
    isCityListVisible.value = false // скрыть список, если строка пуста
  }
})

const fetchCities = () => {
  const params = new URLSearchParams({
    v: '5.81',
    country_id: '1',
    region_id: '0',
    offset: '0',
    need_all: '0',
    count: '10',
    q: searchQuery.value
  })

  fetch(`api/method/database.getCities?${params}`, { headers })
    .then((response) => response.json())
    .then((data) => {
      cities.value = data.response.items
    })
    .catch((error) => {
      console.error('Ошибка при получении данных:', error)
    })
}

const handleSelectCity = (event) => {
  selectedCity.value = event.target.value
  searchQuery.value = event.target.options[event.target.selectedIndex].text
  isCityListVisible.value = false // скрыть выпадающий список
  cities.value = []
}

// Логика для поиска университетов
const headers = { Authorization: `Bearer ${import.meta.env.VITE_KEY_NAME}` }

const fetchUniversities = (index) => {
  const stateUniversity = educationList.value[index].stateUnivesity
  const params = new URLSearchParams({
    v: '5.81',
    q: stateUniversity,
    city_id: selectedCity.value,
    count: '10'
  })

  fetch(`api/method/database.getUniversities?${params}`, { headers })
    .then((response) => response.json())
    .then((data) => {
      educationList.value[index].universities = data.response.items
      educationList.value[index].isVisibleUniversities =
        stateUniversity.trim() !== '' && data.response.items.length > 0
    })
    .catch((error) => {
      console.error('Ошибка при получении данных:', error)
      educationList.value[index].universities = []
      educationList.value[index].isVisibleUniversities = false
    })
}

// Обработка выбора университета
const handleSelectUniversity = (index, event) => {
  const selectedUniversity = event.target.value
  educationList.value[index].stateUnivesity = selectedUniversity
  educationList.value[index].isVisibleUniversities = false
}
</script>

<style scoped></style>
