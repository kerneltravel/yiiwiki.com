<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet version="2.0"
                xmlns:html="http://www.w3.org/TR/REC-html40"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
    <xsl:template match="/">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>网站地图 | Sitemap</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style type="text/css">
body{
    font-family:Arial,sans-serif;
    font-size:12px;
}
h1{
    border-bottom: 2px solid #D8582B;
    padding-bottom: 5px;
}
#info {
    background-color:whitesmoke;
    border:1px #ccc solid;
    padding:5px 13px 5px 13px;
    margin:10px;
    color:#555;
}
#info a{
    color: #D8582B;
    text-decoration: none;
}
#info a:hover{
    text-decoration: underline;
}

#info p {
    line-height:16px;
}

td {
    font-size:11px;
}

th {
    text-align:left;
    padding-right:30px;
    font-size:11px;
    color: #D8582B;
    border-bottom: 1px solid #D8582B;
}
tr:hover,tr.even:hover{
    background-color:#FBE3E4;
}
tr.even {
    background-color:whitesmoke;
}

#footer {
    border-top: 2px solid #D8582B;
    padding:5px;
    font-size:8pt;
    color:gray;
}

#footer a {
    color:gray;
}

a {
    color:black;
}
                </style>
            </head>
            <body>
                <xsl:variable name="always" select="'总是'"/>
                <xsl:variable name="hourly" select="'每小时'"/>
                <xsl:variable name="daily" select="'每天'"/>
                <xsl:variable name="weekly" select="'每周'"/>
                <xsl:variable name="monthly" select="'每月'"/>
                <xsl:variable name="yearly" select="'每年'"/>
                <xsl:variable name="never" select="'从不'"/>
                <h1>网站地图 | Sitemap</h1>
                <div id="info">
                    <p>
                        这是一个XML格式的网站地图，它支持大多数搜索引擎(像：<a href="http://www.google.com">谷歌 Google</a>, <a href="http://search.msn.com">MSN Search</a> 和 <a href="http://www.yahoo.com">雅虎 YAHOO</a>)。
                    </p>
                </div>
                <div id="content">
                    <table cellpadding="5">
                        <tr style="border-bottom:1px #333 solid;">
                            <th>网络地址 | Url</th>
                            <th>优先级 | Priority</th>
                            <th>变化频率 | Change Frequency</th>
                            <th>最后修改 | LastChange (GMT)</th>
                        </tr>
                        <xsl:for-each select="sitemap:urlset/sitemap:url">
                            <tr>
                                <xsl:if test="position() mod 2 != 1">
                                    <xsl:attribute  name="class">even</xsl:attribute>
                                </xsl:if>
                                    <td>
                                        <xsl:variable name="itemURL">
                                            <xsl:value-of select="sitemap:loc"/>
                                        </xsl:variable>
                                        <a href="{$itemURL}">
                                            <xsl:value-of select="sitemap:loc"/>
                                        </a>
                                    </td>
                                <td>
                                    <xsl:value-of select="concat(sitemap:priority*100,'%')"/>
                                </td>
                                <td>
                                    <xsl:choose>
                                        <xsl:when test="sitemap:changefreq = 'always'">
                                            <xsl:value-of select="$always"/>
                                        </xsl:when>
                                        <xsl:when test="sitemap:changefreq = 'hourly'">
                                            <xsl:value-of select="$hourly"/>
                                        </xsl:when>
                                        <xsl:when test="sitemap:changefreq = 'daily'">
                                            <xsl:value-of select="$daily"/>
                                        </xsl:when>
                                        <xsl:when test="sitemap:changefreq = 'weekly'">
                                            <xsl:value-of select="$weekly"/>
                                        </xsl:when>
                                        <xsl:when test="sitemap:changefreq = 'monthly'">
                                            <xsl:value-of select="$monthly"/>
                                        </xsl:when>
                                        <xsl:when test="sitemap:changefreq = 'yearly'">
                                            <xsl:value-of select="$yearly"/>
                                        </xsl:when>
                                        <xsl:when test="sitemap:changefreq = 'never'">
                                            <xsl:value-of select="$never"/>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:value-of select="$never"/>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </td>
                                <td>
                                    <xsl:value-of select="sitemap:lastmod"/>
                                </td>
                            </tr>
                        </xsl:for-each>
                    </table>
                </div>
                <div id="footer">
					使用extsitemap生成.
                </div>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>