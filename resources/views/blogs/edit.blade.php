@extends('layouts.app')

@section('import')
    <link href="https://unpkg.com/@wangeditor/editor@latest/dist/css/style.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container mb-5 pb-5">
        <a href="{{ route('blogs.index') }}" class="btn btn-dark mb-2">Back</a>
        <form action="{{ route('blogs.update', ['blog' => $post->id]) }}" method="post">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ $post->title }}" required minlength="2" maxlength="100">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <label for="body" class="form-label">Body</label>
            <div class="border rounded mb-3">
                <div id="toolbar-container">
                    <!-- 工具栏 -->
                </div>
                <div id="editor-container" style="height: 300px;">
                    <!-- 编辑器 -->
                </div>
            </div>

            <div class="mb-3 d-none">
                <label for="body" class="form-label">Body</label>
                <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" required
                    minlength="2"></textarea>
                @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="published_at" class="form-label">Published at</label>
                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                    value="{{ $post->published_at->format('Y-m-d') . 'T' . $post->published_at->format('H:i') }}"
                    id="published_at" name="published_at" required>
                @error('published_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="published" value="1"
                    @if ($post->published) checked @endif>
                <label class="form-check-label">
                    Published
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="published" value="0"
                    @if (!$post->published) checked @endif>
                <label class="form-check-label">
                    Draft
                </label>
            </div>

            <div class="mb-3 text-center">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>

        </form>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/@wangeditor/editor@latest/dist/index.js"></script>
    <script>
        const {
            createEditor,
            createToolbar
        } = window.wangEditor

        const editorConfig = {

            placeholder: 'Type here...',
            onChange(editor) {
                const html = editor.getHtml()
                console.log('editor content', html)
                document.getElementById('body').value = html
                // 也可以同步到 <textarea>
            },

            MENU_CONF: {
                // 配置上传图片
                uploadImage: {
                    server: "http://127.0.0.1:8000/api/upload/img",
                },
            },

        }

        const editor = createEditor({
            selector: '#editor-container',
            html: '{!! $post->body !!}',
            config: editorConfig,
            mode: 'default', // or 'simple'
        })

        const toolbarConfig = {}

        const toolbar = createToolbar({
            editor,
            selector: '#toolbar-container',
            config: toolbarConfig,
            mode: 'default', // or 'simple'
        })
    </script>
@endsection
