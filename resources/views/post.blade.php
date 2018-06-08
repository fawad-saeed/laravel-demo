@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{$post->body}}

                        <ul v-for="comment in comments">
                            <li>
                                @{{ comment.user.name }} : @{{ comment.body }}
                            </li>
                        </ul>
                    </div>
                </div>
                <textarea class="form-control" name="body" v-model="commentsBox" @keyUp="postComments"></textarea>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                comments: {},
                commentsBox: '',
                post: {!! $post->toJson() !!},
                user: {!! Auth::check() ? Auth::user()->toJson() : '{}' !!}
            },
            mounted() {
                this.getComments();
                this.listen();
            },
            methods: {
                getComments(){
                    axios.get(`/api/posts/${this.post.id}/comments?api_token=${this.user.api_token}`)
                        .then(response => {
                            this.comments = response.data.data;
                        })
                        .catch(err => {
                            console.log(err);
                        });
                },
                postComments(e){
                    if (e.keyCode === 13) {
                        axios.post(`/api/posts/${this.post.id}/comment`, {
                            api_token: this.user.api_token,
                            body: this.commentsBox
                        })
                            .then(response => {
                                this.commentsBox = '';
                            })
                            .catch(err => {
                                console.log(err);
                            });
                    }
                },
                listen(){
                    Echo.private(`post.` + this.post.id)
                        .listen('NewComment', (comment) => {
                            this.comments.unshift(comment)
                        })
                }
            }
        });
    </script>
@endsection