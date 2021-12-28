@if(!empty($fundamentals))
    <h6 class="divider-heading heading-adjust-mobile uppercase">Stock <span class="extra-bold">Profile</span></h6>
    <div class="divider divider-adjust heading-adjust-mobile" id="profile-divider"></div>

    <div class="row content-sections" id="profile-section">
        <table class="table-adjust-margin-bottom">
            <thead>
            <tr class="no-border">
                <th class="uppercase table-heading">Company Description</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td class="right-margin-padding text-justify" colspan="5">{!! str_replace("â", "\"", str_replace("Â", "&reg;", str_replace("TM", "&#8482;", str_replace("â€”", " - ", str_replace("â€™", "'", $fundamentals["General"]["Description"]))))) !!}<br/><br/></td>
            </tr>
            </tbody>
        </table>
    </div>
@endif