<?php

$orderClass = '';
$class = $class ?? '';

if (isset($orderLinkRoute) AND isset($order))
{
    $orderClass = ($order == $column) ? 'sorting_' . $orderDirection : 'sorting';
    $orderLinkParams = isset($orderLinkParams) ? $orderLinkParams : [];
    $orderLinkParams = array_merge($orderLinkParams, [
            'order' => $column,
            'orderDirection' => (($order == $column && $orderDirection == 'asc') ? 'desc' : 'asc')]);
    $orderLink = route($orderLinkRoute, $orderLinkParams);
}
?>

<th class="{{ $orderClass }} {{ $class }}">
    @if (isset($orderLink))
    <a href="{{ $orderLink }}">{{ $label }}</a>
    @else
    {{ $label }}
    @endif
</th>