<script>
import ProductCart from '@/Components/Cart/ProductCart.vue';
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

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
  methods: {
    getDataFromCart(obj, item) {
    //   console.log(obj, item);
      router.visit(route('product.addCart'), { method: 'post', data: { id: item.id, qty: obj.qty }, preserveState: true,
        onSuccess: ({ props }) => {
          if (props.flash.message.rt_code === 1) {
            Swal.fire(`${item.name}成功加入購物車`);
          }
        }
      });
    }
  },
};
</script>

<template>
  <section id="frontend-index" class="max-w-7xl mx-auto">
    <h1 class="title">商品列表</h1>
    <div class="flex gap-[30px] flex-wrap">
      <!-- <div v-for="item in response.rt_data ?? []" :key="item.id" class="card">
        <div class="name"><img :src="item.image" class="w-[200px] aspect-[4/3] object-cover" alt=""></div>
        <div class="name">商品名稱 : {{ item.name }}</div>
        <div class="name">商品價格 : ${{ item.price }}</div>
        <div class="name">商品描述 : {{ item.desc }}</div>
      </div> -->
      <ProductCart v-for="item in response.rt_data ?? []" :key="item.id" :product-info="item" @add-cart="(obj) =>
        getDataFromCart(obj, item)">
        test123
        <template #text>
          <div>
            test456
          </div>
        </template>
        789
      </ProductCart>
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
