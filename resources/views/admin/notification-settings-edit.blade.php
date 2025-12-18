<x-admin-layout>
    @section('title', 'Edit Notification - Admin')

    <div class="notification-settings-edit">
        <h2>Edit Notification: {{ $setting->name }}</h2>

        <form action="{{ route('admin.notification-settings.update', $setting->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>
                    <input type="checkbox" name="enabled" {{ $setting->enabled ? 'checked' : '' }}>
                    Enabled
                </label>
            </div>

            <div class="form-group">
                <label>Subject / Title</label>
                <input type="text" name="subject" value="{{ $setting->subject }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Message Template</label>
                <textarea name="template" rows="6" class="form-control">{{ $setting->template }}</textarea>
                <small>Use placeholders like <code>{user_name}</code>, <code>{order_id}</code></small>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
        </form>
    </div>
</x-admin-layout>
