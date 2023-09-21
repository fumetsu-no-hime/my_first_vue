<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

export default {
  components: {
    AuthenticatedLayout,
    Head,
  },
  data() {
    return {
      formData: {
        name: '',
        image: '',
        otherImage: [],
        price: '',
        public: '',
        desc: '',
      },
      imageSize: 0,
    };
  },
  computed: {

  },
  methods: {
    submitData() {
      // 驗證
      if (this.imageSize > 3145728) return Swal.fire('圖片檔案過大');
      router.visit(route('product.store'), {
        method: 'post',
        data: this.formData,
        preserveState: true,
        onSuccess: ({ props }) => {
          if (props.flash.message.rt_code === 1) {
            Swal.fire({
              title: '新增成功',
              showDenyButton: true,
              confirmButtonText: '回列表',
              denyButtonText: `取消`,
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                router.get(route('product.list'));
              }
            });
          }
        },
      });
    },
    uploadImage(e) {
      const reader = new FileReader();
      reader.readAsDataURL(e.target.files[0]);
      reader.onload = () => {
        this.formData.image = reader.result;
        this.imageSize += e.target.files[0].size;
      };
    },
    uploadOtherImage(e) {
      const reader = new FileReader();
      reader.readAsDataURL(e.target.files[0]);
      reader.onload = () => {
        this.formData.otherImage.push({
          id: Math.max(0, ...this.formData.otherImage.map(item => item.id)) + 1,
          image: reader.result,
          size: e.target.files[0].size,
        //   sort: this.formDta.otherImage.length + 1,
        });
        this.imageSize += e.target.files[0].size;
      };
    },
    removeImage(id) {
      this.imageSize -= this.formData.otherImage.find((item) => item.id === id).size;
      this.formData.otherImage = this.formData.otherImage.filter((item) => item.id !== id);
    },
  }
};
</script>

<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product 新增商品</h2>
      </div>
    </template>
    <section id="product-create" class="px-[15px] py-[10px] rounded-[6px]">
      <form @submit.prevent="submitData()">
        <label for="">
          商品名稱:
          <input v-model="formData.name" name="name" type="text" required>
        </label>
        <label>
          商品照片:
          <div class="relative inline-block">
            <div v-if="!formData.image" class="w-[200px] border aspect-[4/3] flex justify-center items-center text-[48px] cursor-pointer">
              +
            </div>
            <img v-else :src="formData.image" class="w-[200px] aspect-[4/3] object-cover" alt="">
            <input class="absolute top-1/2 left-1/2 w-[1px] h-[1px] opacity-0 translate-y-[10px]" name="image" type="file" required @change="(e) => uploadImage(e)">
          </div>
        </label>
        其他照片:
        <div class="flex flex-wrap">
          <div v-for="item in formData.otherImage" :key="item.id" class="relative me-3">
            <img :src="item.image" alt="" class="w-[200px] border aspect-[4/3] flex justify-center items-center text-[48px] object-cover">
            <button type="button" class="rounded-full w-[15px] h-[15px] flex justify-center items-center bg-[red] text-white absolute top-0 right-0 translate-x-1/2 -translate-y-1/2" @click="removeImage(item.id)">X</button>
          </div>
        </div>
        <label class="w-[200px] border aspect-[4/3] flex justify-center items-center text-[48px] cursor-pointer">
          +
          <input type="file" class="hidden" @change="(e) => uploadOtherImage(e)">
        </label>
        <label>
          商品價格
          <input v-model="formData.price" name="price" type="text" required>
        </label>
        <div class="flex items-center gap-[10px]">公開/非公開
          <label>
            <input v-model="formData.public" name="public" type="radio" value="1" required>公開
          </label>
          <label>
            <input v-model="formData.public" name="public" type="radio" value="2">不公開
          </label>
        </div>
        <label for="">
          商品描述
          <input v-model="formData.desc" name="desc" type="text">
        </label>
        <div class="flex justify-center items-center gap-[45px]">
          <Link :href="route('product.list')" class="btn">取消新增</Link>
          <button type="submit" class="btn">確認新增</button>
        </div>
      </form>
    </section>
  </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
#product-create {
  form {
    @apply flex flex-col gap-[10px] bg-white px-[15px] py-[10px];
    .btn {
      @apply border border-[#3c3c3c] bg-[#e3e3e3] font-bold px-[15px] py-[10px] rounded-[5px];
    }
  }
}
</style>
