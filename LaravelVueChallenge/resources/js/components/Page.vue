<template>
    <div>
    <div class="container">
        <div class="table-wrapper">
          <div class="table-title">
            <div class="row">
              <div class="col-sm-6">
                <h2>Manage <b>Products</b></h2>
              </div>
              <div class="col-sm-6">
                <a href="#addProductModal" @click="GetCategories();  Clear();" class="btn btn-success" data-toggle="modal"><i class="material-icons"><i class="fa-solid fa-plus"></i></i> <span>Add New Product</span></a>

                
                <!-- <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons"><i class="fa-solid fa-trash"></i></i> <span>Delete</span></a> -->
              </div>
              <span>FIlter by Category : &nbsp;</span>
              <br>
              <div class="row">
                <div class="col-lg">

                <select v-model="selectedCategory" class="form-control">
                  <option v-for="category in listcategories"
                  :key="category.id"  :value="category.id"> {{category.name}}</option>
                 
              </select>
                <br>
                </div>
                <div class="col-lg">
                  <button @click="Filter()" class="btn btn-primary">Filter</button>
                </div>
              </div>
            </div>
          </div>
          <table id="table" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>
                  #ID
                </th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in listproducts.data"
              :key="product.id">
                <td>
                  {{product.id}}
                </td>
                <td>{{product.name}}</td>
                <td>{{product.description}}</td>
                <td>{{product.price}}$</td>
                <td><img class="img-thumbnail w-25" v-bind:src="product.image" alt=""></td>
                <td>
                  <ul>
                 <li v-for="category in product.categories" :key="category">{{category}}</li>
                </ul>
                </td>
                <td>
                  <a href="#addProductModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen" @click="ShowProduct(product.id)"></i></i></a>
                  <a href="#deleteProductModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete"><i class="fa-solid fa-trash" @click="forDelete(product.id)"></i></i></a>
                </td>
              </tr>
            
             
             
            </tbody>
          </table>
          

          <Pagination
                    :data="listproducts"
                    @pagination-change-page="GetProducts"
                  />
          <!--div class="clearfix">
            <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
            <ul class="pagination">
              <li class="page-item disabled"><a href="#">Previous</a></li>
              <li class="page-item"><a href="#" class="page-link">1</a></li>
              <li class="page-item"><a href="#" class="page-link">2</a></li>
              <li class="page-item active"><a href="#" class="page-link">3</a></li>
              <li class="page-item"><a href="#" class="page-link">4</a></li>
              <li class="page-item"><a href="#" class="page-link">5</a></li>
              <li class="page-item"><a href="#" class="page-link">Next</a></li>
            </ul>
          </div-->
        </div>
      </div>
      <!-- Edit Modal HTML -->
      <div id="addProductModal" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <form>
              <div class="modal-header">
                <h4 class="modal-title">Add Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Name</label>
                  <input v-model="product_add.name" type="text" class="form-control">
                </div>
                <div
                        class="text-danger"
                      >
                        {{ this.errors.name }}
                      </div>
                <div class="form-group">
                  <label>Price</label>
                  <input v-model="product_add.price" type="text" class="form-control">
                </div>

                <div
                        class="text-danger"
                      >
                        {{ this.errors.price }}
                      </div>
                <div class="form-group">
                  <label>Description</label>
                  <textarea v-model="product_add.description" class="form-control"></textarea>
                </div>

                <div
                        class="text-danger"
                      >
                        {{ this.errors.description }}
                      </div>
                <div class="form-group">
                  <label>Category</label>
                  
                    <br><div  v-for="category in listcategories"
                    :key="category.id" >
                  <input v-model="product_add.category" type="checkbox" :value="category.id">
                  {{category.name}}
                  </div>
                  

                  
                </div>
                <div class="form-group">
                  <label>Image</label>
                  <input v-model="product_add.image" type="text" class="form-control">
                </div>
              </div>
              <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                <input v-if="id_update == 0" type="button" class="btn btn-success" value="Add" @click="AddProduct">
                <input v-else type="button" class="btn btn-success" value="Update" @click="UpdateProduct(id_update)">
              </div>
            </form>
          </div>
        </div>
      </div>
      
      <!-- Delete Modal HTML -->
      <div id="deleteProductModal" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <form>
              <div class="modal-header">
                <h4 class="modal-title">Delete Product {{id_delete}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to delete these Records?</p>
               
              </div>
              <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                <input type="button" class="btn btn-danger" value="Delete" @click="RemoveProduct(id_delete)">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</template>

<script>



import LaravelVuePagination from "laravel-vue-pagination";
    export default {
      data() {
    return {
      listproducts: "",
      listcategories: "",

      product_add:{
        name:"",
        description:"",
        price:"",
        image:"",
        category:[]
      },

      errors:{},

      id_delete:"",
      id_update:0,
      selectedCategory:""

      


    }
      },

       methods:{

        AddProduct() {
      axios
        .post("api/add", this.product_add)
        .then((res) => {
          if (res.data.status == 200) {
           this.GetProducts();
           Clear();
          
          }
          else if(res.data.message=="Error"){
            this.errors = res.data.errors;
          }
        })
        .catch((error) => {
          

          
        });
    },


    UpdateProduct(id) {
      axios
        .put("api/update/"+id, this.product_add)
        .then((res) => {
          if (res.data.status == 200) {
           this.GetProducts();
          
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },




        GetProducts(page = 1) {
   //   $("#kt_customers_table").waitMe({});
      axios
        .get("api/products?page=" + page)
        .then((res) => {
          this.listproducts = res.data.products;
         
          

         // $("#kt_customers_table").waitMe("hide");
        })
        .catch((error) => console.log(error));
    },


    //delete

    RemoveProduct(id) {
    
          axios
            .delete("api/remove/" + id)
            .then((res) => {
              if (res.data.status == 200) {
                console.log(res.data.message);
                this.GetProducts();
              
                $('#deleteProductModal').modal('hide');
              }
              
            })
            .catch((err) => console.log(err));
        
      
      
    },

    ShowProduct(id) {
    this.id_update = id;

    console.log(id);
    axios
      .get("api/products/" + id)
      .then((res) => {
        if (res.data.status == 200) {
          console.log(res.data.message);
          this.product_add = res.data.product;

          this.product_add.category = res.data.product.categories;

          console.log(res.data.product.categories);
          //this.GetProducts();
        }
        
      })
      .catch((err) => console.log(err));
  


},


Filter(page = 1){
  console.log(this.selectedCategory);
  axios
        .get("api/filter?selectedCategory="+this.selectedCategory+"&page=" + page)
        .then((res) => {
          this.listproducts = res.data.products;
          
          

         // $("#kt_customers_table").waitMe("hide");
        })
        .catch((error) => console.log(error));
    },



forDelete(id){
this.id_delete = id;
},
forupdate(id){
  this.id_update = id;
},

Clear(){
this.product_add.name = "";
this.product_add.description = "";
this.product_add.image = "";
this.product_add.price = "";
this.product_add.category = [];
  
},




GetCategories() {
 
  
    
      axios
        .get("api/categories")
        .then((res) => {
          this.listcategories = res.data.categories;
         

          console.log(res.data);

         // $("#kt_customers_table").waitMe("hide");
        })
        .catch((error) => console.log(error));
    },
       },

       components: {
    Pagination: LaravelVuePagination,

  },

        mounted() {
            this.GetProducts();
            this.GetCategories();
          
        }
    }
</script>
