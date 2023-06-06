<ul class="nav nav-pills mb-2">
    <!-- Account -->
    <li class="nav-item">
        <a class="nav-link {{ $conta }}"
            href="@isset($user->id){{ url('users/show') }}/{{ $user->id }}@else{{ url('users/novo') }}@endisset ">
            <i data-feather="user" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Dados da Conta</span>
        </a>
    </li>
    <!-- security -->
    @isset($user->id)
        <li class="nav-item">
            <a class="nav-link {{ $permissoes }} " href="{{ url('users/show/permissoes') }}/{{ $user->id }}">
                <i data-feather="lock" class="font-medium-3 me-50"></i>
                <span class="fw-bold">Permissões do Usuário</span>
            </a>
        </li>
    @endisset
    <!-- billing and plans -->

</ul>
