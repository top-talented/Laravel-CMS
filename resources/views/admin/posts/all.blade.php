@extends('admin.layouts.master')

@section('extra_css')
    <link rel="stylesheet" type="text/css" href="/assets/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css"
          href="/assets/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="/assets/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
@stop

@section('extra_js')
    <script type="text/javascript" src="/assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
            src="/assets/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript"
            src="/assets/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript"
            src="/assets/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            Metronic.handleTables();
        });
    </script>
@stop

@section('content')

    <h3 class="page-title">
        {{trans('messages.posts')}}
        <small>{{trans('messages.manage_posts')}}</small>
    </h3>

    <div class="page-bar">
        <ul class="page-breadcrumb">

            <li>
                <a href="/admin">{{trans('messages.home')}}</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <a href="/admin/posts">{{trans('messages.posts')}}</a>
            </li>

        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green-meadow">

                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-puzzle"></i>{{trans('messages.all_posts')}}
                    </div>
                    <div class="actions">
                        <a href="/admin/posts/create" class="btn red">
                            <i class="fa fa-plus"></i> {{trans('messages.create_new_post')}} </a>
                    </div>
                </div>

                <div class="portlet-body">

                    @include('admin.layouts.notify')

                    <div class="col-md-4" style="padding-bottom: 10px">


                    <div class="widget ">
                        <form action="/admin/posts/" method="GET" >
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="{{trans('messages.search..')}}">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
          </span>
                            </div>
                        </form>
                    </div>

                    </div>

                    <table class="table table-striped table-bordered table-hover"  >
                        <thead>
                        <tr>
                            <th>{{trans('messages.id')}}</th>
                            <th>{{trans('messages.featured_image')}}</th>
                            <th>{{trans('messages.title')}}</th>
                            <th>{{trans('messages.sub_category')}}</th>
                            <th>{{trans('messages.source')}}</th>
                            <th>{{trans('messages.views')}}</th>
                            <th>{{trans('messages.published_on')}}</th>
                            <th>{{trans('messages.status')}}</th>
                            <th>{{trans('messages.edit')}}</th>
                            <th>{{trans('messages.delete')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td> {{$post->id}} </td>
                                <td>

                                    @if($post->render_type == \App\Posts::RENDER_TYPE_TEXT)
                                        {{trans('messages.text_post')}}
                                    @else
                                        <a target="_blank" href="{{$post->featured_image}}"><img
                                                    src="{{$post->featured_image}}" style="width:100px;"/></a>
                                    @endif

                                </td>
                                <td><a href="/{{$post->slug}}" target="_blank">{{$post->title}}</a></td>
                                <td> {{isset($post->category)?$post->category->title:'NO CATEGORY'}} </td>

                                @if($post->type == \App\Posts::TYPE_SOURCE)
                                    <td>{{isset($post->source)?$post->source->channel_title:'NO SOURCE'}}</td>
                                @else
                                    <td> {{trans('messages.manual')}} </td>
                                @endif

                                <td> {{$post->views}} </td>
                                <td> {{$post->created_at}} </td>

                                @if($post->status == \App\Posts::STATUS_PUBLISHED)
                                    <td>
                                        <label class="label label-success label-sm">{{trans('messages.published')}}</label>
                                    </td>
                                @endif

                                @if($post->status == \App\Posts::STATUS_HIDDEN)
                                    <td><label class="label label-warning label-sm">{{trans('messages.hidden')}}</label>
                                    </td>
                                @endif

                                <td><a href="/admin/posts/edit/{{$post->id}}"
                                       class="btn btn-warning btn-sm">{{trans('messages.edit')}}</a>
                                </td>
                                <td><a data-href="/admin/posts/delete/{{$post->id}}" data-toggle="modal"
                                       data-target="#confirm-delete"
                                       class="btn btn-danger btn-sm">{{trans('messages.delete')}}</a></td>
                            </tr>


                        @endforeach
                        </tbody>


                    </table>

                    <?php echo $posts->render(); ?>




                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    {{trans('messages.delete_post')}}
                                </div>
                                <div class="modal-body" style="background-color:#FFB848; color:#ffffff;">
                                    <h4>
                                        <i class="fa fa-exclamation-triangle"></i> {{trans('messages.delete_post_desc')}}
                                    </h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal">{{trans('messages.cancel')}}</button>
                                    <a class="btn btn-danger btn-ok">{{trans('messages.delete')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
@stop