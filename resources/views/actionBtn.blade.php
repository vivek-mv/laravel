<div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        Action
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-right">
        {{ $view }}
        {{ $showStackInfo }}
        {{ $edit }}
        {{ $delete }}
    </ul>
</div>