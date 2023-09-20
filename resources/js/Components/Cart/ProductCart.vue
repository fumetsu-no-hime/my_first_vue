<script>
export default {
  props: {
    productInfo: {
      type: Object,
      required: true,
      default: () => {
        return {};
      },
    },
  },
};
</script>

<template>
  <section class="card">
    <img :src="productInfo.image" class="w-full aspect-[4/3] object-cover" alt="">
    <h3 class="name">商品名稱 : {{ productInfo.name }}</h3>
    <h3 class="name">商品價格 : ${{ productInfo.price }}</h3>
    <h3 class="name">商品描述 : {{ productInfo.desc }}</h3>
  </section>
</template>

<style lang="scss" scoped>
  .card {
    @apply w-[calc(25%-22.5px)] border p-6;
  }
</style>
