<!-- sidebar.blade.php -->
<aside class="md:flex md:flex-shrink-0 bg-black">
    <div class="flex flex-col w-64">

        <div class="flex flex-col pt-5 pb-5 overflow-y-auto">
            <div class="flex items-center flex-shrink-0 px-4 h-8">
                <pre class="brand-ascii bg-transparent text-white text-xs leading-tight" style="font-size: 6px;">
   _____________  _______   __  _______
  / __/_  __/ _ \/ __/ _ | /  |/  / __/
 _\ \  / / / , _/ _// __ |/ /|_/ /\ \  
/___/ /_/ /_/|_/___/_/ |_/_/  /_/___/  
</pre>
                {{-- <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow"> --}}
            </div>
        </div>

        @include('ui::cp.navigation')
        @include('ui::cp.meta')

    </div>
</aside>
