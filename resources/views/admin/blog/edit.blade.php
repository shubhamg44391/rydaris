@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="margin-bottom: 20px;">
            <h2>Edit Blog Post</h2>
        </div>

        <div class="panel-body">
            <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-color);">Title <span style="color: red;">*</span></label>
                    <input type="text" name="title" required value="{{ old('title', $blog->title) }}" style="width: 100%; padding: 10px; border-radius: var(--radius); border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: #fff;">
                    @error('title') <span style="color: #fb7185; font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-color);">Custom Slug (Optional)</label>
                    <input type="text" name="slug" value="{{ old('slug', $blog->slug) }}" style="width: 100%; padding: 10px; border-radius: var(--radius); border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: #fff;">
                    <small style="color: #94a3b8; display: block; margin-top: 5px;">Leave empty to keep the current slug or auto-generate.</small>
                    @error('slug') <span style="color: #fb7185; font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-color);">Meta Title (SEO)</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}" style="width: 100%; padding: 10px; border-radius: var(--radius); border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: #fff;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-color);">Meta Description (SEO)</label>
                    <textarea name="meta_description" rows="2" style="width: 100%; padding: 10px; border-radius: var(--radius); border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: #fff;">{{ old('meta_description', $blog->meta_description) }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-color);">Meta Keywords (SEO)</label>
                    <input type="text" name="meta_keyword" value="{{ old('meta_keyword', $blog->meta_keyword) }}" placeholder="e.g. car rental, blog, tips" style="width: 100%; padding: 10px; border-radius: var(--radius); border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: #fff;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-color);">Excerpt (Short Summary)</label>
                    <textarea name="excerpt" rows="3" style="width: 100%; padding: 10px; border-radius: var(--radius); border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: #fff;">{{ old('excerpt', $blog->excerpt) }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-color);">Content <span style="color: red;">*</span></label>
                    <textarea name="content" required rows="10" style="width: 100%; padding: 10px; border-radius: var(--radius); border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: #fff;">{{ old('content', $blog->content) }}</textarea>
                    @error('content') <span style="color: #fb7185; font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: var(--text-color);">Featured Image</label>
                    @if($blog->image)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="Current Image" style="max-width: 200px; border-radius: 8px;">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*" style="width: 100%; padding: 10px; border-radius: var(--radius); border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: #fff;">
                    <small style="color: #94a3b8; display: block; margin-top: 5px;">Leave empty to keep the current image.</small>
                    @error('image') <span style="color: #fb7185; font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group" style="margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ $blog->is_published ? 'checked' : '' }} style="width: 18px; height: 18px;">
                    <label for="is_published" style="font-weight: bold; color: var(--text-color); cursor: pointer;">Publish immediately</label>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" style="background: var(--brand); color: #061218; font-weight: bold; border: none; border-radius: var(--radius); padding: 10px 20px; cursor: pointer;">Update Post</button>
                    <a href="{{ route('admin.blog.index') }}" style="background: rgba(255,255,255,0.1); color: #fff; font-weight: bold; border-radius: var(--radius); padding: 10px 20px; text-decoration: none;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
