<div class="showStackInfo" data-toggle="modal" data-target="#myModal" style="cursor: pointer">
    {{ $query->firstName  }} {{ $query->middleName }} {{ $query->lastName }}
    <input type="hidden" value="{{ $query->stackId }}">
</div>