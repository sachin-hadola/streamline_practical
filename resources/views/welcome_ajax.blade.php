<ul>
    @foreach($childrendata as $key_child => $value_child)
    @if($value_child->type == 2)
    <li>
        <a target="_blank" href="{{env('APP_URL')}}/public/uploads/{{$value_child->name}}"><i class="fa fa-file"></i> {{$value_child->name}}</a>
        <i class="fa fa-trash deletedate" style="padding: 0 10px;" title="Delete" data-id="{{$value_child->id}}"></i>
    </li>
    @endif
    @if($value_child->type == 1)

    <li data-id="{{$value_child->id}}"><i class="fa fa-folder"></i> {{$value_child->name}}

        <?php $childrendata_one = $value_child->children()->get(); ?>    
        @if(count($childrendata_one) >= 1)
        <div class="arrow" data-id="{{$value_child->id}}"><i class="fa fa-angle-down"></i></div>
        @endif

        @if($value_child->type == 1)
        <i class="fa fa-plus openmodalclass" data-id="{{$value_child->id}}" style="padding: 0px 20px;" title="Add" ></i>
        <i class="fa fa-trash deletedate" title="Delete" data-id="{{$value_child->id}}"></i>
        @endif

        <div class="ddddd_{{$value_child->id}}"></div>

    </li>
    @endif

    @endforeach
</ul>