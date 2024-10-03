<template>
  <div class="min-h-screen bg-gray-100 p-8">
    <!-- Форма для заполнения данных -->
    <div class="max-w-3xl mx-auto mb-10">
      <div class="flex justify-between">
        <Button @click="goToMain" class="w-24" variant="link">На главную</Button>
        <h2 class="text-2xl font-semibold mb-6">Введите данные для резюме</h2>
      </div>

      <div class="grid grid-cols-1 gap-4">
        <input
          v-model="profession"
          type="text"
          placeholder="Профессия"
          class="border p-2 rounded"
        />
        <input v-model="searchQuery" type="text" :placeholder="selectedCity" :class="inputClass" />
        <select
          @change="handleSelectCity"
          v-if="isVisible"
          id="years"
          size="5"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        >
          <option v-if="cities.length === 0" disabled>Ничего не найдено</option>
          <option v-for="city in cities" :key="city.id" :value="city.id">
            {{ city.title }}
          </option>
        </select>
        <input
          v-model="photoUrl"
          type="text"
          placeholder="Ссылка на фото"
          class="border p-2 rounded"
        />
        <input v-model="fullName" type="text" placeholder="ФИО" class="border p-2 rounded" />
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
        <input v-model="email" type="email" placeholder="Email" class="border p-2 rounded" />
        <input
          v-model="birthDate"
          type="date"
          placeholder="Дата рождения"
          class="border p-2 rounded"
        />
        <Select v-model="education">
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
          class="grid grid-cols-2 gap-4"
          v-if="
            education === `colledge` || education === `not_university` || education === `university`
          "
        >
          <div class="flex flex-col gap-4">
            <input
              v-model="stateUnivesity"
              :placeholder="selectedUniversity"
              :class="inputClassUniversity"
              type="text"
              class="border p-2 rounded"
            />
            <select
              @change="handleChangeUniversity"
              v-if="isVisibleUniversities"
              id="years"
              size="5"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            >
              <option v-if="Universities.length === 0" disabled>Ничего не найдено</option>
              <option v-for="univers in Universities" :key="univers.id">
                {{ univers.title }}
              </option>
            </select>
          </div>

          <input v-model="faculty" type="text" placeholder="Факультет" class="border p-2 rounded" />
          <input
            v-model="spec"
            type="text"
            placeholder="Специализация"
            class="border p-2 rounded"
          />
          <input
            v-model="year_finish"
            type="text"
            placeholder="Год окончания"
            class="border p-2 rounded"
          />
        </div>

        <div
          v-if="
            education === `colledge` || education === `not_university` || education === `university`
          "
          class="flex flex-col gap-4"
        >
          <Button @click="addEducation" class="flex bg-green-600 hover:bg-green-500"
            >Добавить дополнительне образование +</Button
          >
          <div
            v-for="(edu, index) in additionalEducation"
            :key="index"
            class="flex justify-between items-center"
          >
            <input
              v-model="edu[index]"
              type="text"
              placeholder="Ссылка на дополнительное образование"
              class="border p-2 rounded w-[800px]"
            />
            <Button @click="removeEducation(index)" variant="link">Удалить</Button>
          </div>
        </div>

        <input
          v-model="desiredSalary"
          type="text"
          placeholder="Желаемая зарплата"
          class="border p-2 rounded"
        />
        <textarea
          v-model="skills"
          placeholder="Ключевые навыки"
          class="border p-2 rounded"
        ></textarea>
        <textarea v-model="about" placeholder="О себе" class="border p-2 rounded"></textarea>
        <StatusResume />
      </div>
    </div>

    <!-- Шаблон резюме -->
    <ResumeForm
      :photoUrl="photoUrl"
      :phone="phone"
      :profession="profession"
      :city="city"
      :fullName="fullName"
      :email="email"
      :birthDate="birthDate"
      :education="education"
      :desiredSalary="desiredSalary"
      :skills="skills"
      :about="about"
      :stateUnivesity="selectedUniversity"
      :faculty="faculty"
      :spec="spec"
      :year_finish="year_finish"
      :isUniversity="isUniversity"
      :educationLabel="educationLabel"
      :additionalEducation="additionalEducation"
      class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md"
    />
    <!-- <div>
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
    </div> -->
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import Button from '@/components/ui/button/Button.vue'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue
} from '@/components/ui/select'
import { useRouter, useRoute } from 'vue-router'
import ResumeForm from '../components/FormStudy.vue'
import StatusResume from '../components/StatusResume.vue'

const profession = ref('')
const city = ref('')
const photoUrl = ref('')
const fullName = ref('')

const email = ref('')
const birthDate = ref('')
const education = ref('')
const desiredSalary = ref('')
const skills = ref('')
const about = ref('')

// Логика для добавления и удаление доп образования

// логика для select

const additionalEducation = ref([])

const addEducation = () => {
  additionalEducation.value.push({ link: '' })
}

const removeEducation = (index) => {
  additionalEducation.value.splice(index, 1)
}

const stateUnivesity = ref('')
const faculty = ref('')
const spec = ref('')
const year_finish = ref('')

const isUniversity = ref(true)

const educationLabel = computed(() => {
  const labels = {
    school: 'Среднее',
    colledge: 'Среднее специальное',
    not_university: 'Неоконченное высшее',
    university: 'Высшее'
  }
  return labels[education.value] || 'не указано'
})

// валидация для телефона

const hasInput = ref(false)

const phone = ref('')
const regexPhone = /^\d{6,10}$/

const isPhoneValid = computed(() => regexPhone.test(phone.value))

// API для городов

const isEmptyResult = ref('Ничего не найдено')

const selectedCity = ref('Город') // Новое свойство для хранения выбранного города

const selectedID = ref()

const cities = ref([])

const searchQuery = ref('')

const headers = {
  'Accept-Language': 'ru',
  Cookie: 'remixlang=1',
  Authorization: `Bearer ${import.meta.env.VITE_KEY_NAME}`
}

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

// Отслеживаем изменения searchQuery и делаем запрос

const isVisible = computed(() => searchQuery.value.trim() !== '' && cities.value.length > 0)

const isVisibleUniversities = computed(
  () => stateUnivesity.value.trim() !== '' && Universities.value.length > 0
)

watch(searchQuery, (newQuery) => {
  if (newQuery) {
    setTimeout(() => {
      fetchCities()
    }, 0)
  }
})

const allSelectedCity = ref()

const handleSelectCity = (event) => {
  const selectedCityId = event.target.value
  allSelectedCity.value = cities.value.find((city) => city.id == selectedCityId)

  console.log(allSelectedCity.value.id) // id города
  console.log(allSelectedCity.value.title) // название города

  selectedCity.value = allSelectedCity.value.title // Устанавливаем выбранный город

  selectedID.value = allSelectedCity.value.id // Устанавлимаем ID выбранного города

  city.value = allSelectedCity.value.title

  searchQuery.value = '' // Очищаем input, чтобы не было лишних запросов
  cities.value = [] // Очищаем список городов
}

const inputClass = computed(() => {
  return selectedCity.value !== 'Город'
    ? 'border p-2 rounded placeholder-black'
    : 'border p-2 rounded placeholder-green'
})

const inputClassUniversity = computed(() => {
  return selectedUniversity.value !== 'Учебное заведение'
    ? 'border p-2 rounded placeholder-black'
    : 'border p-2 rounded placeholder-green'
})

// API для университетов, в соответствии с городом

const Universities = ref([])

const fetchUniversity = () => {
  const params = new URLSearchParams({
    v: '5.81',
    city_id: selectedID.value,
    q: stateUnivesity.value
  })

  fetch(`api/method/database.getUniversities?${params}`, { headers })
    .then((response) => response.json())
    .then((data) => {
      console.log(data)
      Universities.value = data.response.items
    })
    .catch((error) => {
      console.error('Ошибка при получении данных:', error)
    })
}

watch(selectedID, (newValue, oldValue) => {
  console.log('Selected ID changed from', oldValue, 'to', newValue)
  fetchUniversity()
})

watch(stateUnivesity, (newQuery) => {
  if (newQuery) {
    fetchUniversity()
  }
})

const selectedUniversity = ref('Учебное заведение')

const handleChangeUniversity = (event) => {
  selectedUniversity.value = event.target.value

  stateUnivesity.value = ''

  Universities.value = []

  console.log(selectedUniversity)
}

// Роутинг

const router = useRouter()

const goToMain = () => {
  router.push('/')
}
</script>

<style lang="scss" scoped></style>
