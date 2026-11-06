<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hambre Cero - Plataforma de Redistribución</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <nav class="bg-emerald-800 border-b border-emerald-900/40 px-4 py-3 fixed w-full top-0 z-50 shadow-md">
        <div class="flex items-center justify-between">
            
            <div class="flex items-center gap-3">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-emerald-100 rounded-lg sm:hidden hover:bg-emerald-700/60 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <span class="sr-only">Abrir menú</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

            
               <a href="/alimentos" class="flex items-center gap-3">
    <div class="bg-emerald-500/20 p-2 rounded-xl border border-emerald-400/30 backdrop-blur-sm flex items-center justify-center">
      
        <svg class="w-6 h-6 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18m0-18C7.5 3 4 6.5 4 11c0 5 4.5 9 8 10m0-18c4.5 0 8 3.5 8 8 0 5-4.5 9-8 10"></path>
        </svg>
    </div>
    <div>
        <span class="text-base font-extrabold text-white tracking-tight block leading-none">Hambre Cero</span>
        <span class="text-[10px] font-medium text-emerald-200 tracking-wider uppercase">Plataforma de Alimentos</span>
    </div>
</a>
            </div>

            <div class="flex items-center gap-3">
                <span class="hidden md:inline-block text-xs font-semibold text-emerald-100 bg-emerald-700/50 px-3 py-1.5 rounded-full border border-emerald-600/50">
                    🟢 Sistema
                </span>
            </div>

        </div>
    </nav>
    
   
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform -translate-x-full bg-white border-r border-slate-200/80 sm:translate-x-0 shadow-sm flex flex-col justify-between">
        
        <div class="h-full px-3 py-4 overflow-y-auto bg-white flex flex-col justify-between">
            
            <div class="space-y-6">
               
                <div>
                    <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Gestión de Insumos</p>
                    <ul class="space-y-1 font-medium">
                        
                   
                        <li>
                            <a href="{{ route('alimentos.index') }}" 
                               class="flex items-center gap-3 px-3 py-2.5 text-slate-700 rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition-all duration-200 group font-semibold text-sm {{ request()->routeIs('alimentos.*') ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-600 rounded-l-none' : '' }}">
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                <span>Alimentos</span>
                            </a>
                        </li>

          
                        <li>
                            <a href="{{ route('ordenes.index') }}" 
                               class="flex items-center justify-between px-3 py-2.5 text-slate-700 rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition-all duration-200 group font-semibold text-sm {{ request()->routeIs('ordenes.*') ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-600 rounded-l-none' : '' }}">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    <span>Órdenes</span>
                                </div>
                            </a>
                        </li>

              
                        <li>
                            <a href="{{ route('carritos.index') }}" 
                               class="flex items-center justify-between px-3 py-2.5 text-slate-700 rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition-all duration-200 group font-semibold text-sm {{ request()->routeIs('carritos.*') ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-600 rounded-l-none' : '' }}">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                                    <span>Carritos</span>
                                </div>
                                
                            </a>
                        </li>

                 
                        <li>
                            <a href="{{ route('lista_deseos.index') }}" 
                               class="flex items-center justify-between px-3 py-2.5 text-slate-700 rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition-all duration-200 group font-semibold text-sm {{ request()->routeIs('lista_deseos.*') ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-600 rounded-l-none' : '' }}">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                    <span>Lista de Deseos</span>
                                </div>
                            </a>
                        </li>

                    </ul>
                </div>

               
                <div>
                    <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Administración</p>
                    <ul class="space-y-1 font-medium">
                        
                     
                        <li>
                            <a href="{{ route('usuarios.index') }}" 
                               class="flex items-center gap-3 px-3 py-2.5 text-slate-700 rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition-all duration-200 group font-semibold text-sm {{ request()->routeIs('usuarios.*') ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-600 rounded-l-none' : '' }}">
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span>Usuarios</span>
                            </a>
                        </li>

                     
                        <li>
                            <a href="{{ route('roles.index') }}" 
                               class="flex items-center gap-3 px-3 py-2.5 text-slate-700 rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition-all duration-200 group font-semibold text-sm {{ request()->routeIs('roles.*') ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-600 rounded-l-none' : '' }}">
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 10h.01M7 13h.01M10 7h10M10 10h10M10 13h10M5 18h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>Roles</span>
                            </a>
                        </li>

                      
                        <li>
                            <a href="{{ route('logs.index') }}" 
                               class="flex items-center gap-3 px-3 py-2.5 text-slate-700 rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition-all duration-200 group font-semibold text-sm {{ request()->routeIs('logs.*') ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-600 rounded-l-none' : '' }}">
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                <span>Logs del Sistema</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

      
            <div class="pt-4 mt-6 border-t border-slate-100">
                @php
                    $usuarioActivo = \App\Models\Usuario::with('rol')->find(session('id_usuario_activo'));
                    $inicialesActivo = $usuarioActivo
                        ? mb_strtoupper(mb_substr($usuarioActivo->nombre, 0, 1) . mb_substr($usuarioActivo->apellido, 0, 1))
                        : '??';
                @endphp
                <div class="flex items-center gap-3 p-2 rounded-xl bg-slate-50 border border-slate-200/60">
                    <div class="w-9 h-9 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-sm shadow-sm shrink-0">
                        {{ $inicialesActivo }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-slate-800 truncate">
                            {{ $usuarioActivo ? $usuarioActivo->nombre . ' ' . $usuarioActivo->apellido : 'Sin usuario activo' }}
                        </p>
                        <p class="text-[10px] text-slate-500 truncate">
                            {{ $usuarioActivo->rol->nombre ?? 'Selecciona un usuario' }}
                        </p>
                    </div>
                </div>

                <form action="{{ route('usuarios.activar') }}" method="POST" class="mt-2 flex items-center gap-1">
                    @csrf
                    <select name="id_usuario" onchange="this.form.submit()"
                            class="flex-1 bg-white border border-slate-200 text-slate-700 text-xs rounded-lg p-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="" disabled {{ $usuarioActivo ? '' : 'selected' }}>Cambiar de usuario…</option>
                        @foreach(\App\Models\Usuario::orderBy('nombre')->get() as $u)
                            <option value="{{ $u->id_usuario }}" {{ $usuarioActivo && $usuarioActivo->id_usuario == $u->id_usuario ? 'selected' : '' }}>
                                {{ $u->nombre }} {{ $u->apellido }}
                            </option>
                        @endforeach
                    </select>
                    <noscript><button type="submit" class="text-xs px-2 py-2 bg-emerald-600 text-white rounded-lg">Ir</button></noscript>
                </form>
            </div>

        </div>
    </aside>

    <div class="p-4 sm:ml-64 mt-16 transition-all duration-300">
    <div class="p-6 bg-white border border-slate-200/80 rounded-2xl shadow-sm min-h-[calc(100vh-5rem)]">

        @if(session('success'))
    <div class="mb-5 p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200">
        ✅ {{ session('success') }}
    </div>
@endif

@if(session('warning'))
    <div class="mb-5 p-4 text-sm text-amber-800 rounded-lg bg-amber-50 border border-amber-200">
        ⚠️ {{ session('warning') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-5 p-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
        ⛔ {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-5 p-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        @yield('contenido')
    </div>
</div>

           

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>