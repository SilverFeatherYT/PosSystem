 <h1>Redeem Info</h1>
 <table>
     <thead>
         <tr>
             <th>Message</th>
             <th>Date</th>
         </tr>
     </thead>
     <tbody id="body">

         @foreach ($redeemMessages as $redeemMessage)
         <tr>
             <td>{{ $redeemMessage->D_RedeemCusMessage }}</td>
             <td>{{ $redeemMessage->created_at }}</td>
         </tr>
         @endforeach

     </tbody>
 </table>
 <div class="paginate">
     {{$redeemMessages->links()}}
 </div>