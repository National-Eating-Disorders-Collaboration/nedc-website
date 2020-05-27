    <% if not $SiteConfig.DisableSurvey %>
    <div class="survey fixed">
        <div class="survey-top-border">
            <h4>Help us improve!</h4>
            <div class=" right survey-actions">
                <a class="js_minimize-survey min"><i class="fa fa-plus"></i></a>
                <a class="js_close-survey close"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="survey-content">
            <h2>$SiteConfig.SurveyHeader</h2>
            <div class="survey-image">
                <img src="$ThemeDir/img/survey.svg" alt="">
            </div>
            <p>$SiteConfig.SurveyText</p>
            <% if $SiteConfig.SurveyLink %>
                <% with $SiteConfig.SurveyLink  %>
                    <a href="$LinkURL" class="btn primary">$Title</a>
                <% end_with %>
            <% end_if %>
            
        </div>
    </div>
    <% end_if %>