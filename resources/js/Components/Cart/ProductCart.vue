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
    <div class="name"><img :src="productInfo.image" class="w-[200px] aspect-[4/3] object-cover" alt=""></div>
    <div class="name">商品名稱 : {{ productInfo.name }}</div>
    <div class="name">商品價格 : ${{ productInfo.price }}</div>
    <div class="name">商品描述 : {{ productInfo.desc }}</div>
  </section>
</template>

<style lang="scss" scoped>
  .card {
    @apply w-[calc(25%-22.5px)] border p-6;
  }
</style>
