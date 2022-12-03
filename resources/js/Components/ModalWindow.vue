<template>
  <div @click="openModal"><slot name="button"></slot></div>
  <div ref="modal" class="modal" @click="closeModal">
    <div class="modal__content">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: "ModalWindow",
  methods: {
    openModal() {
      this.$refs['modal'].classList.add('modal-active');
    },
    closeModal() {
      this.$refs['modal'].classList.remove('modal-active');
    },
  },
}
</script>

<style scoped>
</style>


