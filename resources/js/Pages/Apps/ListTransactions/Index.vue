<template>
  <Head>
    <title>Products - Aplikasi Kasir</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"
                  ><i class="fa fa-shopping-bag"></i> TRANSACTIONS LIST</span
                >
              </div>
              <div class="card-body">
                <form @submit.prevent="handleSearch">
                  <div class="input-group mb-3">
                    <input
                      type="text"
                      class="form-control"
                      v-model="search"
                      placeholder="search by transaction title..."
                    />
                    <button
                      class="btn btn-primary input-group-text"
                      type="submit"
                    >
                      <i class="fa fa-search me-2"></i> SEARCH
                    </button>
                  </div>
                </form>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">TXR Invoice</th>
                      <th scope="col">Product</th>
                      <th scope="col">Customer</th>
                      <th scope="col">Bayar</th>
                      <th scope="col">Kembali</th>
                      <th scope="col">Diskon</th>
                      <th scope="col">Total</th>
                      <th scope="col">Kasir</th>
                      <th scope="col">Deskripsi</th>
                      <th scope="col" style="width: 20%">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(transaction, index) in transactions.data"
                      :key="index"
                    >
                      <td>{{ transaction.invoice }}</td>
                      <td>
                        {{ transaction.category_name }} -
                        {{ transaction.product_title }}
                      </td>
                      <td>{{ transaction.customer_name }}</td>
                      <td>Rp. {{ formatPrice(transaction.cash) }}</td>
                      <td>Rp. {{ formatPrice(transaction.change) }}</td>
                      <td>Rp. {{ formatPrice(transaction.discount) }}</td>
                      <td>Rp. {{ formatPrice(transaction.grand_total) }}</td>
                      <td>{{ transaction.cashier_name }}</td>
                      <td>{{ transaction.description }}</td>
                      <td class="text-center">
                        <button
                          class="btn btn-primary btn-sm me-1"
                          v-if="hasAnyPermission(['transactions-list.print'])"
                          @click="
                            openPrintInvoiceWindow(
                              '/apps/transactions/print?invoice=' +
                                transaction.invoice
                            )
                          "
                        >
                          <i class="fa fa-print"></i> PRINT
                        </button>

                        <button
                          @click.prevent="destroy(transaction.id)"
                          class="btn btn-danger btn-sm"
                          v-if="hasAnyPermission(['transactions-list.index'])"
                        >
                          <i class="fa fa-trash"></i> DELETE
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <Pagination :links="transactions.links" align="end" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
//import layout
import LayoutApp from "../../../Layouts/App.vue";

//import component pagination
import Pagination from "../../../Components/Pagination.vue";

//import Heade and Link from Inertia
import { Head, Link } from "@inertiajs/inertia-vue3";

//import ref from vue
import { ref } from "vue";

//import inertia adapter
import { Inertia } from "@inertiajs/inertia";

//import sweet alert2
import Swal from "sweetalert2";

//import component barcode
import Barcode from "../../../Components/Barcode.vue";

export default {
  methods: {
    openPrintInvoiceWindow(url) {
      window.open(url, "_blank");
    },
  },
  //layout
  layout: LayoutApp,

  //register components
  components: {
    Head,
    Link,
    Pagination,
    Barcode,
  },

  //props
  props: {
    transactions: Object,
  },
  //composition API
  setup() {
    //define state search
    const search = ref("" || new URL(document.location).searchParams.get("q"));

    //define method search
    const handleSearch = () => {
      Inertia.get("/apps/transactions-list", {
        //send params "q" with value from state "search"
        q: search.value,
      });
    };

    //method "destroy"
    const destroy = (id) => {
      //show confirm
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          //send to server
          Inertia.delete(`/apps/transactions-list/${id}`);

          //show alert
          Swal.fire({
            title: "Deleted!",
            text: "Product deleted successfully.",
            icon: "success",
            timer: 2000,
            showConfirmButton: false,
          });
        }
      });
    };

    return {
      search,
      handleSearch,
      destroy,
    };
  },
};
</script>

<style>
</style>
