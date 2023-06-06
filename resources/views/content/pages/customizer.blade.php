{{-- BEGIN: Customizer --}}
<div class="customizer d-none d-md-block">

    <a class="customizer-toggle d-flex align-items-center justify-content-center" href="javascript:void(0);">
        <i class="spinner" data-feather="settings"></i>
    </a>

    <div class="customizer-content">
        <!-- Customizer header -->
        <div class="customizer-header px-2 pt-1 pb-0 position-relative">
            <h4 class="mb-0">Customização de tema</h4>
            <p class="m-0">Costumize o tema em tempo real</p>

            <a class="customizer-close" href="javascript:void(0);"><i data-feather="x"></i></a>
        </div>

        <hr />

        <form action="" id="skinConfig">
            <!-- Styling & Text Direction -->
            <div class="customizer-styling-direction px-2">
                <p class="fw-bold">Skins</p>
                <div class="d-flex">
                    <div class="form-check me-1">
                        <input type="radio" id="skinlight" name="skinradio" class="form-check-input layout-name"
                            checked="" data-layout="">
                        <label class="form-check-label" for="skinlight">Claro</label>
                    </div>
                    <div class="form-check me-1">
                        <input type="radio" id="skinbordered" name="skinradio" class="form-check-input layout-name"
                            data-layout="bordered-layout">
                        <label class="form-check-label" for="skinbordered">Bordas</label>
                    </div>
                    <div class="form-check me-1">
                        <input type="radio" id="skindark" name="skinradio" class="form-check-input layout-name"
                            data-layout="dark-layout">
                        <label class="form-check-label" for="skindark">Dark</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="skinsemidark" name="skinradio" class="form-check-input layout-name"
                            data-layout="semi-dark-layout">
                        <label class="form-check-label" for="skinsemidark">Meio Dark</label>
                    </div>
                </div>
            </div>

            <hr />

            <!-- Menu -->

            <div class="customizer-menu px-2">
                <div id="customizer-menu-collapsible" class="d-flex">
                    <p class="fw-bold me-auto m-0">Menu Colapsado
                    </p>
                    <div class="form-check form-check-primary form-switch">
                        <input type="checkbox" class="form-check-input" id="collapse-sidebar-switch"
                            @if ($configData['sidebarClass'] == 'menu-collapsed') checked="true" @else checked="false" @endif>
                        <label class="form-check-label" for="collapse-sidebar-switch"></label>
                    </div>
                </div>
            </div>
            <hr />

            <!-- Layout Width -->
            <div class="customizer-footer px-2">
                <p class="fw-bold">Largura do Layout</p>
                <div class="d-flex">
                    <div class="form-check me-1">
                        <input type="radio" id="layout-width-full" name="layoutWidth" class="form-check-input"
                            checked="">
                        <label class="form-check-label" for="layout-width-full">Tela Cheia</label>
                    </div>
                    <div class="form-check me-1">
                        <input type="radio" id="layout-width-boxed" name="layoutWidth" class="form-check-input">
                        <label class="form-check-label" for="layout-width-boxed">Box</label>
                    </div>
                </div>
            </div>
            <hr />

            <!-- Navbar -->
            <div class="customizer-navbar px-2">
                <div id="customizer-navbar-colors">
                    <p class="fw-bold">Cor da barra de navegação</p>
                    <ul class="list-inline unstyled-list">
                        <li class="color-box bg-white border @if ($configData['navbarColor'] == '') selected @endif"
                            data-navbar-default=""></li>
                        <li class="color-box bg-primary @if ($configData['navbarColor'] == 'bg-primary') selected @endif"
                            data-navbar-color="bg-primary"></li>
                        <li class="color-box bg-secondary @if ($configData['navbarColor'] == 'bg-secondary') selected @endif"
                            data-navbar-color="bg-secondary"></li>
                        <li class="color-box bg-success @if ($configData['navbarColor'] == 'bg-success') selected @endif"
                            data-navbar-color="bg-success"></li>
                        <li class="color-box bg-danger @if ($configData['navbarColor'] == 'bg-danger') selected @endif"
                            data-navbar-color="bg-danger"></li>
                        <li class="color-box bg-info @if ($configData['navbarColor'] == 'bg-info') selected @endif"
                            data-navbar-color="bg-info"></li>
                        <li class="color-box bg-warning @if ($configData['navbarColor'] == 'bg-warning') selected @endif"
                            data-navbar-color="bg-warning"></li>
                        <li class="color-box bg-dark @if ($configData['navbarColor'] == 'bg-dark') selected @endif"
                            data-navbar-color="bg-dark"></li>
                    </ul>
                </div>

                <p class="navbar-type-text fw-bold">Tipo da barra de navegação</p>
                <div class="d-flex">
                    <div class="form-check me-1">
                        <input type="radio" id="nav-type-floating" name="navType" class="form-check-input"
                            @if ($configData['navbarClass'] == 'floating-nav') checked="" @endif>
                        <label class="form-check-label" for="nav-type-floating">Flutuante</label>
                    </div>
                    <div class="form-check me-1">
                        <input type="radio" id="nav-type-sticky" name="navType" class="form-check-input"
                            @if ($configData['navbarClass'] == 'sticky-nav') checked="" @endif>
                        <label class="form-check-label" for="nav-type-sticky">Descolado</label>
                    </div>
                    <div class="form-check me-1">
                        <input type="radio" id="nav-type-static" name="navType" class="form-check-input"
                            @if ($configData['navbarClass'] == 'static-nav') checked="" @endif>
                        <label class="form-check-label" for="nav-type-static">Estático</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="nav-type-hidden" name="navType" class="form-check-input"
                            @if ($configData['navbarClass'] == 'hidden-nav') checked="" @endif>
                        <label class="form-check-label" for="nav-type-hidden">Oculto</label>
                    </div>
                </div>
            </div>
            <hr />

            <!-- Footer -->
            <div class="customizer-footer px-2">
                {{ $configData['footerType'] }}
                <p class="fw-bold">Tipo do Rodapé</p>
                <div class="d-flex">
                    <div class="form-check me-1">
                        <input type="radio" id="footer-type-sticky" name="footerType" class="form-check-input"
                            @if ($configData['footerType'] == 'footer-sticky') checked="" @endif>
                        <label class="form-check-label" for="footer-type-sticky">Descolado</label>
                    </div>
                    <div class="form-check me-1">
                        <input type="radio" id="footer-type-static" name="footerType" class="form-check-input"
                            @if ($configData['footerType'] == 'footer-static') checked="" @endif>
                        <label class="form-check-label" for="footer-type-static">Estático</label>
                    </div>
                    <div class="form-check me-1">
                        <input type="radio" id="footer-type-hidden" name="footerType" class="form-check-input"
                            @if ($configData['footerType'] == 'footer-hidden') checked="" @endif>
                        <label class="form-check-label" for="footer-type-hidden">Oculto</label>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- End: Customizer --}}
