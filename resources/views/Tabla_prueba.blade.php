<table border="1">
    <tr>
        <th>Fecha</th>
        <th>Tipo</th>
        <th>IP Origen</th>
        <th>IP Destino</th>
        <th>Protocolo</th>
    </tr>

    @foreach($eventos as $evento)

    <tr>

        <td>{{ $evento['timestamp'] ?? '' }}</td>

        <td>{{ $evento['event_type'] ?? '' }}</td>

        <td>{{ $evento['src_ip'] ?? '' }}</td>

        <td>{{ $evento['dest_ip'] ?? '' }}</td>

        <td>{{ $evento['proto'] ?? '' }}</td>

    </tr>

    @endforeach

</table>