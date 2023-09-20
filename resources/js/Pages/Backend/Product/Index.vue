<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

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
    },
    deleteProduct(id) {
      Swal.fire({
        title: '確定要刪除嗎?',
        showDenyButton: true,
        confirmButtonText: '刪除',
        denyButtonText: `取消`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          router.visit(route('product.delete'), { method: 'delete', data: { id } });
        }
      });
    },
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
    <section id="product" class="flex justify-center items-center mt-[25px]">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>商品圖片</th>
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
            <td>&nbsp;&nbsp;{{ index + 1 }}&nbsp;&nbsp;</td>
            <td>
              <img class="w-[150px] aspect-[3/4] object-cover mx-auto" :src="item.image" alt="商品圖片">
            </td>
            <td>{{ item.name }}</td>
            <td>{{ item.price }}</td>
            <td>{{ isPublic(item.public) }}</td>
            <td>{{ item.timeFormat }}</td>
            <td>{{ item.desc }}</td>
            <td>
              <Link :href="route('product.edit', { id: item.id })">
                <button type="button" class="px-6 py-2 border rounded-[6px] border-black me-2 my-1">編輯</button>
              </Link>
              <button type="button" class="px-6 py-2 border rounded-[6px] text-white border-black bg-[red]" @click="deleteProduct(item.id)">刪除</button>
            </td>
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
