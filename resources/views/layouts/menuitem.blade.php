@if (Auth::user()->hasRole("SuperAdmin") || Auth::user()->hasPermissionTo("$route->path", 'web'))
<el-menu-item index="{{$route->path}}" v-route='@json($route)' :disabled="@json($route->disabled)">
    <span><i class="{{$route->icon}}"></i>{{$route->label}}</span>
</el-menu-item>
@endif
