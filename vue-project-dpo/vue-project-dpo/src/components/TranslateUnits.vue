<template>
  <div class="flex display justify-center flex-col items-center h-screen gap-6">
    <div class="flex items-center gap-2">
      <Button @click="backToMain" class="w-24" variant="link">На главную</Button>
      <h1 class="text-black-600">Задание №1 Форма быстрого перевода</h1>
    </div>

    <div class="grid w-full max-w-sm items-center gap-1.5">
      <Label for="foots to metrs">Футы в метры</Label>
      <Input
        @keydown.enter="handleMeters"
        v-model="foots"
        id="email"
        type="number"
        placeholder="Введите футы"
      />
      <div class="flex items-center justify-between mt-2">
        <Button type="submit" @click="handleMeters" class="w-32 flex">Расчитать</Button>
        <p>Результат: {{ meters.toFixed(3) }} м</p>
      </div>
    </div>
    <div class="grid w-full max-w-sm items-center gap-1.5">
      <Label for="foots to metrs">Морские мили в километры</Label>
      <Input
        @keydown.enter="handleKm"
        v-model="meles"
        id="email"
        type="number"
        placeholder="Введите мили"
      />
      <div class="flex items-center justify-between mt-2">
        <Button type="submit" @click="handleKm" class="w-32 flex">Расчитать</Button>
        <p>Результат: {{ km.toFixed(3) }} км</p>
      </div>
    </div>
    <div class="grid w-full max-w-sm items-center gap-1.5">
      <Label for="foots to metrs">Градусы в радианы</Label>
      <Input
        @keydown.enter="handleRadian"
        v-model="grad"
        id="email"
        type="number"
        placeholder="Введите градусы"
      />
      <div class="flex items-center justify-between mt-2">
        <Button type="submit" @click="handleRadian" class="w-32 flex">Расчитать</Button>
        <p>Результат: {{ radian.toFixed(3) }} радиан</p>
      </div>
    </div>
    <div class="grid w-full max-w-sm items-center gap-1.5">
      <Label for="foots to metrs">Температуру по Цельсию в температуру по Фаренгейту</Label>
      <Input
        @keydown.enter="handleFahrenheit"
        v-model="cell"
        id="email"
        type="number"
        placeholder="Введите градусы по цельсию"
      />
      <div class="flex items-center justify-between mt-2">
        <Button type="submit" @click="handleFahrenheit" class="w-32 flex">Расчитать</Button>
        <p>Результат: {{ f.toFixed(3) }} F</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { Button } from './ui/button'
import { useRoute, useRouter } from 'vue-router'

// футы в метры

const foots = ref(0)
const meters = ref(0)

console.log(foots.value)

const handleMeters = () => {
  meters.value = foots.value * 0.3048
}

// морские мили в километры

const meles = ref(0)
const km = ref(0)

const handleKm = () => {
  km.value = meles.value * 1.60934
}

// градусы в радианы

const grad = ref(0)
const radian = ref(0)

const handleRadian = () => {
  radian.value = (grad.value * 3.14) / 180
}

// температуру по Цельсию в температуру по Фаренгейту

const cell = ref(0)
const f = ref(0)

const handleFahrenheit = () => {
  f.value = cell.value * (9 / 5) + 32
}

// роутинг

const router = useRouter()

const backToMain = () => {
  router.push('/')
}
</script>

<style lang="scss" scoped></style>
