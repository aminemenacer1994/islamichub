<template>
  <i class="bi bi-whatsapp text-right mr-2 h4"
     @click="shareTafseerViaWhatsApp"
     aria-expanded="false"
     data-bs-placement="top"
     title="Share on Whatsapp"
     style="color: rgba(0, 191, 166); cursor: pointer;"></i>
</template>

<script>
export default {
  name: 'WhatsAppShareTafseer',
  props: {
    tafseerToShare: {
      type: String,
      required: true
    }
  },
  methods: {
    shareTafseerViaWhatsApp() {
      const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(this.tafseerToShare)}`;
      window.open(url, '_blank');
    }
  }
};
</script>

<style scoped>
.text-right {
  text-align: right;
}
.mr-2 {
  margin-right: 0.5rem;
}
.h4 {
  font-size: 1.5rem;
}
</style>
