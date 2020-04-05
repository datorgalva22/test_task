<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TestTask LTV</title>

        <link rel="stylesheet" type="text/css" href="/public/css/styles.css" />
    </head>

    <div id="test_task" v-cloak>

        <body>
            <h2>Guide</h2>
            <p>Select channel:</p>

            <div class="tab">
                <button  v-for="channel in channels" class="tablinks" v-bind:class="{ active: currentChannelId == channel.id }" @click="getData('guide', channel.id), currentChannelId = channel.id, infoBox=false">{{channel.title}}</button>

                <div class="right">
                    <button  class="tablinks right" @click="getData('renewGuide'), infoBox = false">Renew TV guide</button>
                </div>
            </div>

            <div id="" class="tabcontent" v-if='currentChannelId != null'>

                <div v-if="!loading && !infoBox" >

                    <div v-for="row in guide">
                        <a href="#" @click.prevent="showInfo(row.guid)">{{row.time_str}} - {{row.title}}  </a> 
                    </div>
                </div>

                <div v-if="!loading && infoBox" >

                    <p>{{info.title}}</p>
                    <img v-bind:src="info.logo" alt="logo" height="100">
                    <br>
                    <p>Upcoming broadcasts:</p>
                    
                    <div v-for="row in info.list">
                        {{row.time_str}} - {{row.channel}}
                    </div>
                    
                    <button  class="button" @click="infoBox = false">Back</button>
                </div>

                <div v-if='loading'>
                    Loading...
                </div>
            </div>

        </body>
    </div>
</body>

<script src="resources/js/vue.js"></script>
<script src="resources/js/vue-resource.min.js"></script>
<script src="resources/js/vue_script.js"></script>
</html>
