<template>
  <Layout>
    <div class="container">

      <Sort @sort="sort"></Sort>

      <ModalWindow ref="modal_upload">
        <template v-slot:button><button class="upload__button">Загрузить изображение</button></template>
        <ImageForm @uploadImage="downloadFiles"/>
        <button class="modal__close-button" @click.prevent="$refs['modal_upload'].closeModal()"></button>
      </ModalWindow>

      <div class="images">
        <div v-for="image in files">
          <Card :name="image.name" :size="image.size" :date="image.date" @deleteImage="deleteImage"/>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
import Layout from '@/Layout/Layout.vue';
import Sort from  '@/Components/Sort.vue';
import ImageForm from  '@/Components/ImageForm.vue';
import Card from '@/Components/Card.vue';
import ModalWindow from '@/Components/ModalWindow.vue';
import axios from "axios";

export default {
  components: {
    Layout,
    Sort,
    Card,
    ImageForm,
    ModalWindow,
  },
  beforeMount() {
    this.downloadFiles();
  },
  data() {
      return {
        files: [],
      }
  },
  methods: {
    downloadFiles() {
      axios.get(this.route('get_all_files')).then(res => {
        this.files = res.data;
      });
    },
    deleteImage(name) {
      this.files = this.files.filter(img => img.name !== name)
    },
    test(a) {
      console.log(a);
    },
    sort(sortType) {
      switch (sortType) {
        case 'name':
          this.sortByName()
          break;
        case 'date':
          this.sortByDate()
          break;
        case 'size':
          this.sortBySize()
          break;
        default:
          break
      }
    },
    sortByName() {
      this.files = this.files.sort((prevImg, nextImg) => {
        const prevName = prevImg.name;
        const nextName = nextImg.name;
        if (prevName.toLowerCase() < nextName.toLowerCase()) {
          return -1;
        }
        if (prevName.toLowerCase() > nextName.toLowerCase()) {
          return 1;
        }
        return 0;
      });
    },
    sortByDate() {
      this.files = this.files.sort((prevImg, nextImg) => {
        const prevImgDate = prevImg.time_u;
        const nextImgDate = nextImg.time_u;
        return prevImgDate - nextImgDate;
      });
    },
    sortBySize() {
      this.files = this.files.sort((prevImg, nextImg) => {
        const prevImgSize = prevImg.size;
        const nextImgSize = nextImg.size;
        return prevImgSize - nextImgSize;
      });
    }
  }
};
</script>
