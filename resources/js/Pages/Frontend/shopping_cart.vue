<script>

export default {
  props: {
    response: {
      type: Object,
      required: false,
      default: () => ({}),
    },
  },
  data() {
    return {
    };
  },
  created() {
    // console.log(this.response);
  },
  methods: {
  },
};
</script>

<template>
  <section id="frontend-cart" class="max-w-7xl mx-auto">
    <h1 class="title">購物車</h1>
    <div>
      <table class="w-full">
        <thead>
          <tr>
            <th>#</th>
            <th class="w-[150px]">商品名稱</th>
            <th>商品圖片</th>
            <th>商品價格</th>
            <th>總計</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in response.rt_data ?? []" :key="item.id">
            <td>{{ index + 1 }}</td>
            <td><img :src="item.product.image" alt="" class="w-[150px] aspect-3/4 object-cover"></td>
            <td>{{ item.product.price }}</td>
            <td>{{ item.qty }}</td>
            <td>${{ item.product.price * item.qty }}</td>
          </tr>
        </tbody>
      </table>
      <div class="flex justify-end my-2">
        <Link :href="route('product.home')" class="btn-base">返回</Link>
      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#frontend-cart {
    @apply w-full h-full;

    .title {
        @apply text-[6.25rem] text-center;
    }

    .btn-base {
        @apply p-1.5 px-3 border-2 rounded-md border-[#656565] bg-[#dfdfdf] cursor-pointer;
    }

    table {
        th, td {
            @apply text-center border border-black;
        }
    }
}
</style>
