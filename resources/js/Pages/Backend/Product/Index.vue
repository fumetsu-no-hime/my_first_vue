<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    AuthenticatedLayout,
    Head,
  },
  props: {
    response: Object,
  },
  methods: {
    isPublic(num = 0) {
      if (![1, 2].includes(num)) return '';
      return num === 1 ? '公開' : '非公開';
    }
  },
};
</script>

<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product</h2>
        <Link :href="route('product.create')">
          <button type="button" class="font-semibold text-xl text-gray-800 leading-tight border border-black p-3 rounded-[6px]">新增商品</button>
        </Link>
      </div>
    </template>
    <section id="product" class="flex justify-center items-center mt-[50px]">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>商品名稱</th>
            <th>商品價格</th>
            <th>公開/非公開</th>
            <th>建立時間</th>
            <th>商品描述</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in response.rt_data" :key="item.id">
            <td>{{ index + 1 }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.price }}</td>
            <td>{{ isPublic(item.public) }}</td>
            <td>{{ item.timeFormat }}</td>
            <td>{{ item.desc }}</td>
            <td>操作</td>
          </tr>
        </tbody>
      </table>
    </section>
  </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
#product {
  table {
    @apply bg-white w-[80%];
    th {
      @apply border border-black;
    }
    td {
      @apply text-center border border-black;
    }
  }
}
</style>
