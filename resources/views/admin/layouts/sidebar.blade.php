<div id="sideBar" 
    class="absolute left-0 top-0 bottom-0 w-64 p-6 flex-none md:-ml-64 md:fixed md:top-0 md:z-30 md:h-screen md:shadow-xl animated faster">


    <!-- sidebar content -->
    <div class="flex flex-col">

        <!-- sidebar toggle -->
        <div class="text-right hidden md:block mb-4">
            <button id="sideBarHideBtn">
                <i class="fad fa-times-circle"></i>
            </button>
        </div>
        <!-- end sidebar toggle -->

        <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">homes</p>

        <!-- link -->
        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            <i class="fad fa-chart-pie text-xs mr-2"></i>
            Analytics dashboard
        </x-nav-link>
        <!-- end link -->

        <!-- link -->
        <x-nav-link :href="route('admin.ecommerce')" :active="request()->routeIs('admin.ecommerce')">
            <i class="fad fa-shopping-cart text-xs mr-2"></i>
            ecommerce dashboard
        </x-nav-link>
        <!-- end link -->

        <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">apps</p>

        <!-- link -->
        <x-nav-link :href="route('admin.email')" :active="request()->routeIs('admin.email')">
            <i class="fad fa-envelope-open-text text-xs mr-2"></i>
            email
        </x-nav-link>
        <!-- end link -->

        <!-- link -->
        <a href="#"
            class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-comments text-xs mr-2"></i>
            chat
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="#"
            class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-shield-check text-xs mr-2"></i>
            todo
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="#"
            class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-calendar-edit text-xs mr-2"></i>
            calendar
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="#"
            class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-file-invoice-dollar text-xs mr-2"></i>
            invoice
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="#"
            class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-folder-open text-xs mr-2"></i>
            file manager
        </a>
        <!-- end link -->


        <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">Admin</p>

        <!-- link -->
        <x-nav-link :href="route('admin.categories.index')" :active="request()->is('admin/categories*')">
            <i class="fad fa-list text-xs mr-2"></i>
            Categories
        </x-nav-link>
        <!-- end link -->

        <!-- link -->
        <x-nav-link :href="route('admin.products.index')" :active="request()->is('admin/products*')">
            <i class="fad fa-box text-xs mr-2"></i>
            Products
        </x-nav-link>
        <!-- end link -->

        <!-- link -->
        <a href="#"
            class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-swatchbook text-xs mr-2"></i>
            colors
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="#"
            class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-atom-alt text-xs mr-2"></i>
            icons
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="#"
            class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-club text-xs mr-2"></i>
            card
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="#"
            class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-cheese-swiss text-xs mr-2"></i>
            Widgets
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="#"
            class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-computer-classic text-xs mr-2"></i>
            Components
        </a>
        <!-- end link -->



    </div>
    <!-- end sidebar content -->

</div>