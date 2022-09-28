<table id="reporttablelist" class="table table-bordered table-striped display "
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sr no</th>
                                        <th>Username</th>
                                        <th>Sender </th>
                                        <th>Report Date</th>
                                        <th>Requested DateTime </th>
                                        <th>Report Status </th>
                                        <th>Download </th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                     @foreach ($data['ReportsList'] as $val)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $val->Username }}</td>
                                        <td>{{ $val->Sender }}</td>
                                        <td>{{ $val->Date }}</td>
                                        <td>{{ $val->RequestedDate }}</td>
                                        @if($val->ReportStatus=="Pending")
                                        <td>Pending</td>
                                        @else
                                        <td>
                                            {{ $val->ReportStatus }}
                                        </td>
                                        @endif
                                        @if($val->ReportPath=="NA")
                                        <td>
                                            <a>
                                <i class=" btn btn-primary fa fa-download"> {{ $val->ReportPath }}</i>
                            </a>
                                           </td>
                                            @else
                                             <td>
                                                <a target="_BLANK"  href="reports/archive/{{ $val->ReportPath }}" >
                                <i class=" btn btn-primary fa fa-download">{{ $val->ReportPath }}</i>
                        </a>
                                            </td>
                                            @endif
                                        <td><a onclick="reportdel('{{ $val->Id }}','{{ $val->ReportPath }}')" 
                                                class="btn btn-info">delete</a></td>
                                    </tr>
                                    @endforeach


                                </tbody>

                            </table>