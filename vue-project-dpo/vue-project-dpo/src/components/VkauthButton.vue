<template>
  <div ref="vkidContainer">
    <!-- Контейнер для OneTap -->
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'

const vkidContainer = ref(null)

onMounted(() => {
  const VKIDScript = document.createElement('script')
  VKIDScript.src = 'https://unpkg.com/@vkid/sdk@<3.0.0/dist-sdk/umd/index.js'
  VKIDScript.onload = () => {
    if ('VKIDSDK' in window) {
      const VKID = window.VKIDSDK

      VKID.Config.init({
        app: 52351936,
        redirectUrl: 'https://rainbow-stardust-e1f9fc.netlify.app',
        source: VKID.ConfigSource.LOWCODE
      })

      const oneTap = new VKID.OneTap()

      oneTap
        .render({
          container: vkidContainer.value, // Указываем контейнер для виджета

          showAlternativeLogin: true
        })
        .on(VKID.WidgetEvents.ERROR, vkidOnError)
        .on(VKID.OneTapInternalEvents.LOGIN_SUCCESS, function (payload) {
          const code = payload.code
          const deviceId = payload.device_id

          VKID.Auth.exchangeCode(code, deviceId).then(vkidOnSuccess).catch(vkidOnError)
        })
    }

    function vkidOnSuccess(data) {
      console.log('Success:', data) // Обработка полученного результата
    }

    function vkidOnError(error) {
      console.error('Error:', error) // Обработка ошибки
    }
  }

  document.body.appendChild(VKIDScript)
})
</script>

<style lang="scss" scoped></style>
