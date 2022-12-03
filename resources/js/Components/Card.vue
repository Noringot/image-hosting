<template>
  <div class="card">
    <img class="card__fullscreen" src="/images/card_images/fs.png" @click="$refs['modal_image'].openModal()" alt="">
    <img class="card__delete" src="/images/card_images/trash.png" @click="deleteImage" alt="">
    <div class="card__image">
      <img :src="'/storage/image/' + name" alt="">
    </div>
    <div class="card__info">
      <div class="card__name">{{ name }}</div>
      <div class="card__size">{{ computedFileSize }}</div>
      <div class="card__date">{{ date }}</div>
    </div>

  </div>
  <ModalWindow ref="modal_image">
    <div class="modal__image">
      <img :src="'/storage/image/' + name" alt="">
      <button class="modal__close-button" @click.prevent="$refs['modal_image'].closeModal()"></button>
    </div>
  </ModalWindow>
</template>

<script>
import ModalWindow from '@/Components/ModalWindow.vue';
import axios from "axios";

export default {
  props: ['name', 'size', 'date'],
  emits: ['deleteImage'],
  components: {
    ModalWindow,
  },
  computed: {
    computedFileSize() {
      let fileSize = this.size;
      if (fileSize >= 1000) {
        fileSize /= 1000;
        if (fileSize >= 1000) {
          fileSize /= 1000;
          if (fileSize >= 1000) {
            fileSize /= 1000;
            return Math.round(fileSize) + ' GB';
          } else {
            return Math.round(fileSize) + ' MB';
          }
        } else {
          return Math.round(fileSize) + ' KB';
        }
      } else {
        return Math.round(fileSize) + ' B';
      }
    }
  },
  methods: {
    deleteImage() {
      axios.post(this.route('delete_image'), {name: this.name}).then(() => {
        this.$emit('deleteImage', this.name);
      })
    }
  }
}
</script>

<style scoped>

.card {
  width: 290px;
  border-radius: 5px;
  overflow: hidden;
  background-color: rgba(155, 111, 170, 0.63);
  position: relative;

}
.card:hover .card__fullscreen {
  opacity: 1;
}
.card:hover .card__delete {
  opacity: 1;
}

.card:hover .card__image img {
  filter: grayscale(1);
}

.card__image {
  width: 100%;
  height: 150px;
}

.card__image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  top: -10px;
  transition: filter .2s ease;
}

.card__info {
  padding: 3px 8px;
}

.card__name {
  font-size: 16px;
  color: #ffff;
}

.card__size {
  font-size: 14px;
  color: #9B6FAA;
}
.card__date {
  font-size: 14px;
  color: #9B6FAA;
  text-align: end;
}

.card__fullscreen {
  opacity: 0;
  width: 44px;
  height: 44px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translateY(-100%) translateX(calc(-100% - 10px));
  cursor: pointer;
  z-index: 1000;
  transition: opacity .2s ease;
  transition-delay: .1s;

}
.card__delete {
  opacity: 0;
  width: 44px;
  height: 44px;
  position: absolute;
  top: 50%;
  left: calc(50% + 10px);
  transform: translateY(-100%);
  cursor: pointer;
  z-index: 1000;
  transition: opacity .2s ease;
  transition-delay: .1s;
}

</style>
