<ul class="nav nav-pills mb-2">
    <!-- Account -->
    <li class="nav-item">
        <a class="nav-link {{ $conta }}" href="{{ route('minha-conta') }}">
            <i data-feather="user" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Dados da Conta</span>
        </a>
    </li>
    <!-- security -->
    <li class="nav-item">
        <a class="nav-link {{ $senha }} " href="{{ route('minha-senha') }}">
            <i data-feather="lock" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Trocar Senha</span>
        </a>
    </li>
    <!-- billing and plans -->

</ul>
