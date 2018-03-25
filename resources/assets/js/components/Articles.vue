<template>
    <div>
        <h2>Posts</h2>
        <form @submit.prevent="addArticle" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title" v-model="article.title">
            </div>
            <div class="form-group">
                <textarea type="text" class="form-control" placeholder="Write your article..." v-model="article.body"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <div :class="loader"></div>
        <div v-for="article in articles" v-bind:key="article.id">
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">{{ article.title }}</h5>
                    <p><span class="badge badge-primary">{{ article.added }} ago</span></p>
                    <p class="card-text">{{ article.body }}</p>
                    <hr>
                    <button @click="editArticle(article)" class="btn btn-success"><i class="fas fa-edit" data-toggle="modal" data-target="#edit"></i></button>                    
                    <button @click="deleteArticle(article.id)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" tabindex="-1" @click="fetchArticles(pagination.prev_page_url)">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" tabindex="-1" @click="fetchArticles(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
        <!-- The Modal -->
        <div class="modal fade" id="edit">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Edit Article</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <form @submit.prevent="addArticle" class="mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Title" v-model="article.title">
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control" placeholder="Title" v-model="article.body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Save</button>
                    </form>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                </div>
                
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data(){
    return {
      articles: [],
      article: {
        id: '',
        title: '',
        body: '',
        added:''
      },
      article_id: '',
      pagination:{},
      edit: false
    }
  },

  created(){
    this.fetchArticles();
  },

  methods: {
    fetchArticles(page_url){
        let vm = this;
        page_url = page_url || '/api/articles'
        fetch(page_url)
          .then(res => res.json())
          .then(res => {
            this.articles = res.data;  
            vm.makePagination(res.meta, res.links);
          })
          .catch(err => console.log(err));
    },
    makePagination(meta, links){
        let pagination = {
            current_page: meta.current_page,
            last_page: meta.last_page,
            next_page_url: links.next,
            prev_page_url: links.prev
        }

        this.pagination = pagination;
    },
    deleteArticle(id){
        if(confirm('Are you Sure?')){
            fetch(`api/article/${id}`, {
                method: 'delete'
            })
            .then(res => res.json())
            .then(data => {
                if(data.ok == 1){
                    alert('Article removed');
                    this.fetchArticles();
                }
            })
            .catch(err=> console.log(err));
        }
    },
    addArticle(){
        if(this.edit === false){
            fetch('api/article',{
                method: 'post',
                body: JSON.stringify(this.article),
                headers: {
                    'content-type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.article.title='';
                this.article.body='';
                if(data.ok == 1){
                    this.fetchArticles();
                }
                
            })
            .catch(err=> console.log(err));
        }else{
            fetch(`api/article/${this.article.id}`,{
                method: 'put',
                body: JSON.stringify(this.article),
                headers: {
                    'content-type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.article.title='';
                this.article.body='';
                if(data.ok == 1){
                    this.fetchArticles();
                }else{
                    console.log('Error');    
                }                
            })
            .catch(err => console.log(err));
        }
    },
    editArticle(article){
        this.edit = true;
        this.article.id = article.id;
        this.article.article_id = article.id;
        this.article.title = article.title;
        this.article.body = article.body;
    }
  }
}
</script>

<style lang="scss" scoped>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
