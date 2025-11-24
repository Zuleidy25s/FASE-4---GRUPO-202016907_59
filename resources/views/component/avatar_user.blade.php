
<div class="inside">
    <div class="edit_avatar text-center">
        <form action="{{ url('account/edit/avatar') }}" method="POST" id="form_avatar_change">
            @csrf
            <a href="#" id="btn_avatar_edit" class="d-block position-relative">
                <div class="d-flex justify-content-center position-relative">
                    <img class="w-25" id="main_avatar" src="{{ Auth::user()->avatar ? Auth::user()->avatar : url('/static/img/avatars-profile/default-avatar.png') }}">
                    <svg id="confirm_check" style="display: none; color: #fff; width: 30px; height: 30px;" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-check-lg position-absolute" viewBox="0 0 16 16">
                        <path d="M13.485 1.757a.75.75 0 0 1 1.06 1.06L5.063 12.3l-4.243-4.243a.75.75 0 0 1 1.06-1.06L5.5 10.938l8.485-8.485z"/>
                    </svg>
                </div>
            </a>
            <div class="avatar-options mt-3">
                <img src="{{ url('/static/img/avatars-profile/avatar1.jpg') }}" class="avatar-option" onclick="selectAvatar('{{ url('/static/img/avatars-profile/avatar1.jpg') }}')">
                <img src="{{ url('/static/img/avatars-profile/avatar2.jpg') }}" class="avatar-option" onclick="selectAvatar('{{ url('/static/img/avatars-profile/avatar2.jpg') }}')">
                <img src="{{ url('/static/img/avatars-profile/avatar3.jpg') }}" class="avatar-option" onclick="selectAvatar('{{ url('/static/img/avatars-profile/avatar3.jpg') }}')">
                <img src="{{ url('/static/img/avatars-profile/avatar4.jpg') }}" class="avatar-option" onclick="selectAvatar('{{ url('/static/img/avatars-profile/avatar4.jpg') }}')">
                <img src="{{ url('/static/img/avatars-profile/avatar5.jpg') }}" class="avatar-option" onclick="selectAvatar('{{ url('/static/img/avatars-profile/avatar5.jpg') }}')">
            </div>
            <input type="hidden" name="avatar" id="selected_avatar">
        </form>
        <form action="{{ url('account/edit/avatar/delete') }}" method="POST" id="form_avatar_delete">
            @csrf
            <button type="submit" class="my-4" style="border: 0px;">Eliminar avatar</button>
        </form>
    </div>
</div>

