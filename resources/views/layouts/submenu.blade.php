@canany($route->children->pluck("path"))
<el-submenu index="{{ $route->path }}" v-route='@json($route)' :disabled="!!{{$route->disabled}}">
    <template slot="title">
        <i class="{{ $route->icon }}"></i>
        <span slot="title">{{ $route->label }}</span>
    </template>
    @foreach ($route->children as $child)
    @includeUnless($child->children->isEmpty(), 'layouts.submenu', ["route" => $child])
    @includeWhen($child->children->isEmpty(), 'layouts.menuitem', ["route" => $child])
    @endforeach
</el-submenu>
@endcanany
