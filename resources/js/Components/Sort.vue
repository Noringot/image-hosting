<template>
  <div class="sort">
    Sort by:
    <button class="sort__button sort__button-name" :class="sortType === 'name' && 'sort__button-active'" @click.prevent="chooseSort">name</button>
    <button class="sort__button sort__button-date" :class="sortType === 'date' && 'sort__button-active'" @click.prevent="chooseSort">date</button>
    <button class="sort__button sort__button-time" :class="sortType === 'size' && 'sort__button-active'" @click.prevent="chooseSort">size</button>
  </div>
</template>

<script>

export default {
  methods: {
    chooseSort(button) {
      this.sortType = button.target.innerHTML;
      this.$emit('sort', this.sortType)
    }
  },
  data() {
    return {
      sortType: 'name'
    }
  }
}
</script>
