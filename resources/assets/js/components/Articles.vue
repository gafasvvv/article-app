<template>
    <div>
        <h2 class="text-center">新規登録</h2>
        <form @submit.prevent="addArticle" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="ライブタイトルについて入力してください"
                v-model="article.title">
            </div>
            <div class="form-group">
                <textarea type="text" class="form-control" placeholder="ライブ内容について入力してください"
                v-model="article.body"></textarea>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="ライブURLがあれば入力してください"
                v-model="article.live_url">
            </div>
            <button type="submit" class="btn btn-light btn-block">投稿</button>
        </form>
        <h2 class="text-center">お笑いライブ情報</h2>
        <div class="card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
            <h3>{{ article.title }}</h3>
            <p>{{ article.body }}</p>
            <p>{{ article.live_url }}</p>
            <hr>
            <div class="row">
                <div class="col-6 text-center">
                    <button @click="editArticle(article)"
                    class="btn btn-warning mb-2">編集</button>
                </div>
                <div class="col-6  text-center">
                    <button @click="deleteArticle(article.id)"
                    class="btn btn-danger">削除</button>
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]"
                class="page-item"><a class="page-link" href="#"
                @click="fetchArticles(pagination.prev_page_url)" >
                前</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">
                Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]"
                class="page-item"><a class="page-link" href="#"
                @click="fetchArticles(pagination.next_page_url)" >
                次</a></li>
            </ul>
        </nav>
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
                live_url: ''
            },
            article_id:'',
            pagination: {},
            edit: false
        }
    },

    created(){
        this.fetchArticles();
    },

    methods: {
        fetchArticles(page_url){
            let vm = this;
            page_url = page_url || 'api/articles';
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // console.log(res.data);
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
            };

            this.pagination = pagination;
        },
        deleteArticle(id){
           if(confirm('記事を削除しますか？')){
               fetch('api/article/'+id,{
                   method: 'delete'
               })
               .then(res => res.json())
               .then(data => {
                   alert('記事を削除しました');
                   this.fetchArticles();
               })
               .catch(err => console.log(err));
           }
        },
        addArticle(){
            if(this.edit === false){
                //追加する
                fetch('api/article',{
                    method: 'post',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        this.article.title = '';
                        this.article.body = '';
                        this.article.live_url = '';
                        alert('投稿完了！');
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
            } else {
                //更新する
                fetch('api/article',{
                    method: 'put',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        this.article.title = '';
                        this.article.body = '';
                        this.article.live_url = '';
                        alert('更新完了！');
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
            }
        },
        editArticle(article){
            this.edit = true;
            this.article.id =article.id;
            this.article.article_id = article.id;
            this.article.title = article.title;
            this.article.body = article.body;
            this.article.live_url = article.live_url;
        }
    }
}
</script>
