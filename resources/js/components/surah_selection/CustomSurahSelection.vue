<template>
  <div class="scrollmenu">
    <a href="#" v-for="data in customSurat" :key="data.id" @click.prevent="selectSurah(data.id)">
      <div class="flex justify-content-center mr-1">
        <span class="badge button-33" :class="{ active: surah === data.id }">{{ data.name }}</span>
      </div>
    </a>
  </div>
</template>

<script>
export default {
  props: {
    customSurahs: Array,
    modelValue: Number
  },
  data() {
    return {
      customSurat: [
        { id: 1, name: 'Al-Fatiha' },
        { id: 2, name: 'Al-Baqarah' },
        { id: 18, name: 'Al-Kahf' },
        { id: 67, name: 'Al-Mulk' },
        { id: 108, name: 'Al-Kawthar' },
        { id: 36, name: 'Ya Seen' },
        { id: 109, name: 'Al-Kafiroon' },
        { id: 112, name: 'Al-Ikhlas' },
        { id: 113, name: 'Al-Falaq' },
        { id: 114, name: 'Al-Nas' },
      ],
    };
  },
  computed: {
    surah() {
      return this.modelValue;
    }
  },
  methods: {
    selectSurah(surahId) {
      this.$emit('update:modelValue', surahId);
    }
  }
};
</script>

<style scoped>
.scrollmenu {
  white-space: nowrap;
  overflow-x: auto;
}

.scrollmenu a {
  display: inline-block;
  text-align: center;
  text-decoration: none;
}

.badge.active {
  background-color: rgba(0, 191, 166, 0.2);
  color: rgb(5, 32, 29);
  border: 1px solid rgba(0, 191, 166);
}
</style>
