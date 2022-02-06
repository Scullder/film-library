<? $count = 0; ?>
<table>
  @for($i = 0; $i < $rows; $i++)
    <tr>
      @for($j = 0; $j < $cols; $j++)
        @if($count >= count($films))
          @break
        @endif
        <td>
            <a href="{{ route('takeFilm', ['filmName' => $films[$count]->film_uri]) }}">
              <img src='/public/images/posters/<? echo $films[$count++]->poster ?>' width=100px height=auto>
            </a>
        </td>
      @endfor
    </tr>
    @if($count >= count($films))
      @break
    @endif
  @endfor
</table>

@yield("links")
