<script>
import ProductCart from '@/Components/Cart/ProductCart.vue';

export default {
  components: {
    ProductCart,
  },
  props: {
    response: {
      type: Object,
      required: false,
      default: () => ({}),
    },
  },
  data() {
    return {
      title: 'Hello World !',
    };
  },
  created() {
    // console.log(this.response);
  },
};
</script>

<template>
  <section id="frontend-index" class="max-w-7xl mx-auto">
    <h1 class="title">{{ title }}</h1>
    <div class="flex justify-center gap-5 mb-5">
      <Link :href="route('register')" class="btn-base">註冊</Link>
      <Link :href="route('dashboard')" class="btn-base">登入</Link>
    </div>
    <div class="flex gap-[30px] ">
      <!-- <div v-for="item in response.rt_data ?? []" :key="item.id" class="card">
        <div class="name"><img :src="item.image" class="w-[200px] aspect-[4/3] object-cover" alt=""></div>
        <div class="name">商品名稱 : {{ item.name }}</div>
        <div class="name">商品價格 : ${{ item.price }}</div>
        <div class="name">商品描述 : {{ item.desc }}</div>
      </div> -->
      <ProductCart v-for="item in response.rt_data ?? []" :key="item.id" :product-info="item"></ProductCart>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#frontend-index {
    @apply w-full h-full overflow-y-auto;

    .title {
        @apply text-[6.25rem] text-center;
    }

    .btn-base {
        @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
    }
}
</style>
