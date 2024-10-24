<template>
  <div class="flex display justify-center flex-col items-center h-screen gap-6">
    <div class="flex items-center gap-2">
      <Button @click="backToMain" class="w-24" variant="link">На главную</Button>
      <h1 class="text-black-600">Задание №1 Форма быстрого перевода</h1>
    </div>

    <!-- Футы в метры -->
    <div class="grid w-full max-w-sm items-center gap-1.5">
      <Label for="foots to metrs">Футы в метры</Label>
      <Input v-model="foots" type="number" placeholder="Введите футы" />
      <Input v-model="meters" type="number" placeholder="Введите метры" />
      <div class="flex items-center justify-between mt-2">
        <p>Футы: {{ foots.toFixed(3) }} фт</p>
        <p>Метры: {{ meters.toFixed(3) }} м</p>
      </div>
    </div>

    <!-- Морские мили в километры -->
    <div class="grid w-full max-w-sm items-center gap-1.5">
      <Label for="miles to km">Морские мили в километры</Label>
      <Input v-model="miles" type="number" placeholder="Введите мили" />
      <Input v-model="km" type="number" placeholder="Введите километры" />
      <div class="flex items-center justify-between mt-2">
        <p>Мили: {{ miles.toFixed(3) }} миль</p>
        <p>Километры: {{ km.toFixed(3) }} км</p>
      </div>
    </div>

    <!-- Градусы в радианы -->
    <div class="grid w-full max-w-sm items-center gap-1.5">
      <Label for="degrees to radians">Градусы в радианы</Label>
      <Input v-model="degrees" type="number" placeholder="Введите градусы" />
      <Input v-model="radians" type="number" placeholder="Введите радианы" />
      <div class="flex items-center justify-between mt-2">
        <p>Градусы: {{ degrees.toFixed(3) }}°</p>
        <p>Радианы: {{ radians.toFixed(3) }} рад</p>
      </div>
    </div>

    <!-- Цельсий в Фаренгейт -->
    <div class="grid w-full max-w-sm items-center gap-1.5">
      <Label for="celsius to fahrenheit">Цельсий в Фаренгейт</Label>
      <Input v-model="celsius" type="number" placeholder="Введите градусы по Цельсию" />
      <Input v-model="fahrenheit" type="number" placeholder="Введите градусы по Фаренгейту" />
      <div class="flex items-center justify-between mt-2">
        <p>Цельсий: {{ celsius.toFixed(3) }}°C</p>
        <p>Фаренгейт: {{ fahrenheit.toFixed(3) }}°F</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { Button } from './ui/button'
import { useRouter } from 'vue-router'

// функция для округления до 3 знаков после запятой
const roundToThree = (value) => parseFloat(value.toFixed(3))

// футы и метры с задержкой
const foots = ref(0)
const meters = ref(0)
let footsTimeout = null
let metersTimeout = null

watch(foots, (newFoots) => {
  clearTimeout(footsTimeout)
  footsTimeout = setTimeout(() => {
    meters.value = roundToThree(newFoots * 0.3048)
  }, 600)
})

watch(meters, (newMeters) => {
  clearTimeout(metersTimeout)
  metersTimeout = setTimeout(() => {
    foots.value = roundToThree(newMeters / 0.3048)
  }, 600)
})

// морские мили и километры с задержкой
const miles = ref(0)
const km = ref(0)
let milesTimeout = null
let kmTimeout = null

watch(miles, (newMiles) => {
  clearTimeout(milesTimeout)
  milesTimeout = setTimeout(() => {
    km.value = roundToThree(newMiles * 1.60934)
  }, 600)
})

watch(km, (newKm) => {
  clearTimeout(kmTimeout)
  kmTimeout = setTimeout(() => {
    miles.value = roundToThree(newKm / 1.60934)
  }, 600)
})

// градусы и радианы с задержкой
const degrees = ref(0)
const radians = ref(0)
let degreesTimeout = null
let radiansTimeout = null

watch(degrees, (newDegrees) => {
  clearTimeout(degreesTimeout)
  degreesTimeout = setTimeout(() => {
    radians.value = roundToThree((newDegrees * Math.PI) / 180)
  }, 600)
})

watch(radians, (newRadians) => {
  clearTimeout(radiansTimeout)
  radiansTimeout = setTimeout(() => {
    degrees.value = roundToThree((newRadians * 180) / Math.PI)
  }, 600)
})

// цельсий и фаренгейт с задержкой
const celsius = ref(0)
const fahrenheit = ref(0)
let celsiusTimeout = null
let fahrenheitTimeout = null

watch(celsius, (newCelsius) => {
  clearTimeout(celsiusTimeout)
  celsiusTimeout = setTimeout(() => {
    fahrenheit.value = roundToThree(newCelsius * (9 / 5) + 32)
  }, 600)
})

watch(fahrenheit, (newFahrenheit) => {
  clearTimeout(fahrenheitTimeout)
  fahrenheitTimeout = setTimeout(() => {
    celsius.value = roundToThree((newFahrenheit - 32) * (5 / 9))
  }, 600)
})

// роутинг
const router = useRouter()
const backToMain = () => {
  router.push('/')
}
</script>

<style lang="scss" scoped></style>
