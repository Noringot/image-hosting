<template>
    <div class="save">
      <div class="upload">
        <button class="upload__button" @click.prevent="uploadFiles">Отправить</button>
      </div>
      <file-pond
        name="test"
        ref="pond"
        label-idle="Drop files here..."
        v-bind:allow-multiple="true"
        accepted-file-types="image/*"
      />
    </div>
</template>

<script>
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);

export default {
  components: {
    FilePond,
  },
  data() {
    return {  };
  },
  methods: {
    uploadFiles() {
      const filesToUpload = this.$refs.pond.getFiles();
      if (filesToUpload.length) {
        const formData = new FormData();

        for (const index in filesToUpload) {
          const { file } = filesToUpload[index];
          formData.append('files[' + index + ']', file);
        }

        axios.post(this.route('upload_files'), formData,
          {
            headers: { "Content-Type": "multipart/form-data" }
          }).then(() => {
            this.$emit('uploadImage');
            this.$refs['pond'].removeFile()
        })
      }
    },
  }
};
</script>
