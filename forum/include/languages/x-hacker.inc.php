<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id$ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nuary";
$lang['month'][2]  = "fe8ru4Ry";
$lang['month'][3]  = "m@rCH";
$lang['month'][4]  = "aPRIl";
$lang['month'][5]  = "m4y";
$lang['month'][6]  = "juNe";
$lang['month'][7]  = "july";
$lang['month'][8]  = "au9us+";
$lang['month'][9]  = "sEp+Em83r";
$lang['month'][10] = "ocT083r";
$lang['month'][11] = "nOVEm83r";
$lang['month'][12] = "d3C3M83r";

$lang['month_short'][1]  = "j4N";
$lang['month_short'][2]  = "fE8";
$lang['month_short'][3]  = "m4r";
$lang['month_short'][4]  = "apR";
$lang['month_short'][5]  = "m4Y";
$lang['month_short'][6]  = "juN";
$lang['month_short'][7]  = "jul";
$lang['month_short'][8]  = "au9";
$lang['month_short'][9]  = "s3P";
$lang['month_short'][10] = "oct";
$lang['month_short'][11] = "n0V";
$lang['month_short'][12] = "dec";

// Dates ---------------------------------------------------------------

// Various date and time formats as used by Beehive Forum. All times are
// expressed as 24 hour time format.

$lang['daymonthyear'] = "%s %s %s";                  // 1 Jan 2005
$lang['monthyear'] = "%s %s";                        // Jan 2005
$lang['daymonthyearhourminute'] = "%s %s %s %s:%s";  // 1 Jan 2005 12:00
$lang['daymonthhourminute'] = "%s %s %s:%s";         // 1 Jan 12:00
$lang['daymonth'] = "%s %s";                         // 1 Jan
$lang['hourminute'] = "%s:%s";                       // 12:00

// Periods -------------------------------------------------------------

// Various time periods as used by Beehive Forum.

$lang['date_periods']['year']   = "%s y3@r";
$lang['date_periods']['month']  = "%s m0n+H";
$lang['date_periods']['week']   = "%s wE3k";
$lang['date_periods']['day']    = "%s D4y";
$lang['date_periods']['hour']   = "%s H0ur";
$lang['date_periods']['minute'] = "%s m1Nut3";
$lang['date_periods']['second'] = "%s \$3Cond";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s y3@Rs";
$lang['date_periods_plural']['month']  = "%s Mon+h5";
$lang['date_periods_plural']['week']   = "%s w33kS";
$lang['date_periods_plural']['day']    = "%s d@Ys";
$lang['date_periods_plural']['hour']   = "%s HourS";
$lang['date_periods_plural']['minute'] = "%s minuteS";
$lang['date_periods_plural']['second'] = "%s \$Ec0nd\$";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shR";   // 5hr
$lang['date_periods_short']['minute'] = "%sm1n";  // 6min
$lang['date_periods_short']['second'] = "%s5ec";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RC3nt";
$lang['average'] = "aVer4ge";
$lang['approve'] = "apPRove";
$lang['banned'] = "b@NneD";
$lang['locked'] = "loCKeD";
$lang['add'] = "aDd";
$lang['advanced'] = "adV4nc3D";
$lang['active'] = "acTiv3";
$lang['style'] = "stYl3";
$lang['go'] = "gO";
$lang['folder'] = "f0lder";
$lang['ignoredfolder'] = "iGNorEd pH0LDer";
$lang['subscribedfolder'] = "sUBSCRi83D f0lDer";
$lang['folders'] = "fOld3Rs";
$lang['thread'] = "thR34D";
$lang['threads'] = "thR34ds";
$lang['threadlist'] = "tHreAD L1s+";
$lang['message'] = "mES\$493";
$lang['from'] = "fR0m";
$lang['to'] = "t0";
$lang['all_caps'] = "alL";
$lang['of'] = "oF";
$lang['reply'] = "r3pLY";
$lang['forward'] = "f0Rw4rd";
$lang['replyall'] = "r3PLy t0 @ll";
$lang['quickreply'] = "qUICk R3PLy";
$lang['quickreplyall'] = "qU1CK R3pLY To 4ll";
$lang['pm_reply'] = "r3Ply 4s Pm";
$lang['delete'] = "dELe+e";
$lang['deleted'] = "dEL3+3D";
$lang['edit'] = "ed1+";
$lang['export'] = "eXpOR+";
$lang['privileges'] = "prIvil3g3s";
$lang['ignore'] = "ignORE";
$lang['normal'] = "nOrm4L";
$lang['interested'] = "iNtER3\$+3D";
$lang['subscribe'] = "sUbscri8e";
$lang['apply'] = "aPplY";
$lang['enable'] = "enABl3";
$lang['download'] = "d0Wnl0@D";
$lang['save'] = "sAVE";
$lang['update'] = "uPd4+E";
$lang['cancel'] = "c4nc3L";
$lang['continue'] = "coN+INu3";
$lang['attachment'] = "a++4chm3nt";
$lang['attachments'] = "aTtachmen+S";
$lang['imageattachments'] = "im49E @t+achm3nt\$";
$lang['filename'] = "f1l3n4Me";
$lang['dimensions'] = "d1M3Ns1oNS";
$lang['downloadedxtimes'] = "dowNLO@DeD: %d +1m3\$";
$lang['downloadedonetime'] = "d0wnLOad3D: 1 T1m3";
$lang['size'] = "s1z3";
$lang['viewmessage'] = "vi3w M3\$S4g3";
$lang['deletethumbnails'] = "dELE+e +hUM8n41ls";
$lang['logon'] = "logON";
$lang['more'] = "mor3";
$lang['recentvisitors'] = "rEC3nt v1S1tors";
$lang['username'] = "userN4ME";
$lang['clear'] = "cLe4r";
$lang['reset'] = "r3s3+";
$lang['action'] = "ac+ioN";
$lang['unknown'] = "unknowN";
$lang['none'] = "n0n3";
$lang['preview'] = "pRev1EW";
$lang['post'] = "po\$T";
$lang['posts'] = "p0S+s";
$lang['change'] = "cHaNGe";
$lang['yes'] = "yeS";
$lang['no'] = "n0";
$lang['signature'] = "sIgNA+uRE";
$lang['signaturepreview'] = "sigN4tuR3 PRevIEw";
$lang['signatureupdated'] = "s1Gn4+Ur3 uPD4teD";
$lang['signatureupdatedforallforums'] = "sIgNA+ure upd@TEd ph0r 4lL f0RUm\$";
$lang['back'] = "b4cK";
$lang['subject'] = "sUbjEc+";
$lang['close'] = "cL0s3";
$lang['name'] = "n@Me";
$lang['description'] = "d3\$CR1ptI0N";
$lang['date'] = "dAte";
$lang['view'] = "v13W";
$lang['enterpasswd'] = "en+eR P4sSw0rD";
$lang['passwd'] = "p@\$SWORd";
$lang['ignored'] = "i9nOReD";
$lang['guest'] = "gUE\$+";
$lang['next'] = "n3X+";
$lang['prev'] = "pReV10uS";
$lang['others'] = "o+hER\$";
$lang['nickname'] = "n1ckn4Me";
$lang['emailaddress'] = "eM41l @dDr3S5";
$lang['confirm'] = "c0nPh1RM";
$lang['email'] = "eM4IL";
$lang['poll'] = "pOLl";
$lang['friend'] = "fRi3Nd";
$lang['success'] = "sUcC3Ss";
$lang['error'] = "eRROr";
$lang['warning'] = "wArN1NG";
$lang['guesterror'] = "s0rrY, j00 NEEd TO 83 LO9geD in +o use +hi5 pH3@tur3.";
$lang['loginnow'] = "l091N NOw";
$lang['unread'] = "unR3Ad";
$lang['all'] = "aLL";
$lang['allcaps'] = "alL";
$lang['permissions'] = "p3RM1sS1Ons";
$lang['type'] = "tyPE";
$lang['print'] = "pRiNT";
$lang['sticky'] = "s+1ckY";
$lang['polls'] = "p0Lls";
$lang['user'] = "u\$3R";
$lang['enabled'] = "eN@bled";
$lang['disabled'] = "dI5a8L3D";
$lang['options'] = "op+1Ons";
$lang['emoticons'] = "eM0+1C0n5";
$lang['webtag'] = "w38TA9";
$lang['makedefault'] = "m4k3 dePH@ul+";
$lang['unsetdefault'] = "uNs3t dEF@ul+";
$lang['rename'] = "r3NamE";
$lang['pages'] = "pAGES";
$lang['used'] = "u\$3D";
$lang['days'] = "d4yS";
$lang['usage'] = "u\$49E";
$lang['show'] = "sh0W";
$lang['hint'] = "hInt";
$lang['new'] = "nEw";
$lang['referer'] = "reFER3R";
$lang['thefollowingerrorswereencountered'] = "t3H phoLLow1NG eRROrs w3Re ENCOunt3r3D:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDMin TO0ls";
$lang['forummanagement'] = "foRUm m4N4gem3nt";
$lang['accessdeniedexp'] = "j00 dO n0T h@Ve pERMi\$s10N +0 us3 +hIS s3ct10N.";
$lang['managefolder'] = "m4n4Ge FOldEr";
$lang['managefolders'] = "m@N4G3 fold3R\$";
$lang['manageforums'] = "m4n4ge f0RUM\$";
$lang['manageforumpermissions'] = "m@n49E phorum p3RMi5si0NS";
$lang['foldername'] = "fOldER n4me";
$lang['move'] = "m0v3";
$lang['closed'] = "cl0s3d";
$lang['open'] = "oPeN";
$lang['restricted'] = "r3s+R1ct3d";
$lang['forumiscurrentlyclosed'] = "%s i5 curren+ly cL0s3d";
$lang['youdonothaveaccesstoforum'] = "j00 do NOT h4V3 4cC35S +0 %s. %s";
$lang['toapplyforaccessplease'] = "t0 @Pply Ph0R 4ccEs\$ pl3@SE C0n+4C+ +3H %s.";
$lang['forumowner'] = "f0RuM owner";
$lang['adminforumclosedtip'] = "iF j00 W@n+ +0 Ch4n93 \$oME S3++in9s 0n your pH0rum cliCk th3 @dmIN l1NK 1n +hE N4V194+10N bAr 480v3.";
$lang['newfolder'] = "n3W phoLDEr";
$lang['nofoldersfound'] = "nO ex1\$+1n9 PH0LdErs F0UnD. +o @dd @ ph0LDer cliCk tHE '@dD neW' But+0n b3L0w.";
$lang['forumadmin'] = "foRUM 4dmin";
$lang['adminexp_1'] = "u\$3 +3h meNU 0n +Eh leph+ T0 mAN493 +HIngs 1N Your phORum.";
$lang['adminexp_2'] = "<b>u5eRS</b> 4LL0ws j00 TO SeT ind1v1du4L u\$ER Perm1ss1ons, inCLUD1n9 APpoin+1N9 MoDer@+0RS AND g@991ng p3opL3.";
$lang['adminexp_3'] = "<b>usEr 9ROups</b> 4Ll0ws j00 +0 CReA+E u\$eR 9r0UP\$ +0 Ass1Gn peRM1SSioNS t0 4S m4ny 0r 4s Phew uSEr\$ quickly 4Nd EAS1ly.";
$lang['adminexp_4'] = "<b>b4N C0ntrolS</b> 4lloWS +H3 84nN1n9 and un-8@NNiNg 0ph 1p @DdR35Se\$, htTP r3phEr3r\$, U\$3RN4m3s, Em@1l @Ddr35se\$ 4nD n1Ckn4ME5.";
$lang['adminexp_5'] = "<b>f0lDERs</b> 4lL0Ws the cr3@T1ON, m0dific4t1on 4nd deL3+1ON oph F0LdeR\$.";
$lang['adminexp_6'] = "<b>r5\$ PHe3d\$</b> alL0W\$ j00 +0 MAn4ge rS\$ f3EDS pH0R prOP4g4Ti0N iN+o yOUr pHorUM.";
$lang['adminexp_7'] = "<b>pROpHIl3s</b> lET\$ j00 cu\$tom1s3 +3h 1t3M\$ TH4T @pp3@r in th3 user proPH1LE\$.";
$lang['adminexp_8'] = "<b>f0RUM \$3++INg\$</b> 4LL0W\$ j00 +0 CuST0M1Se y0Ur PH0Rum's nAme, 4ppe@r4ncE 4nd manY o+h3r ThinGs.";
$lang['adminexp_9'] = "<b>sT@r+ p@9e</b> L3+S j00 cus+Om1s3 Y0ur f0rum'\$ \$t4R+ pa93.";
$lang['adminexp_10'] = "<b>fORum \$+YLE</b> ALL0WS J00 TO g3NeR4+3 r@ndoM s+YlEs fOR your Ph0rUM m3Mb3rs t0 uSE.";
$lang['adminexp_11'] = "<b>w0RD filter</b> 4ll0ws j00 +o philTer WOrdS j00 D0N'+ w4n+ +0 83 used 0N your ph0rUM.";
$lang['adminexp_12'] = "<b>p0\$+1nG S+4Ts</b> 9ENEr@t3\$ 4 R3p0rt liSTiN9 +h3 +op 10 p0sterS in @ d3PhinEd per10D.";
$lang['adminexp_13'] = "<b>foRUm LiNks</b> LEts J00 M4nage +Eh link\$ dr0pdown iN the n4v194TI0N B@R.";
$lang['adminexp_14'] = "<b>v13w L09</b> L1\$t\$ r3C3N+ @c+i0NS bY +eh fORum mOD3R4TorS.";
$lang['adminexp_15'] = "<b>m4n@g3 f0rumS</b> L3+S j00 Cre@T3 and d3l3+3 4nd Cl0\$E 0R rEOPEn foRUM\$.";
$lang['adminexp_16'] = "<b>gLObaL foRUM \$e+tING\$</b> @llOW\$ j00 t0 m0d1fy SEt+1n9\$ wH1Ch 4Fph3cT @lL forumS.";
$lang['adminexp_17'] = "<b>poS+ 4pprOV@l queu3</b> 4llOws J00 to Vi3W 4ny POstS @w@1t1n9 4pprov4l By 4 m0D3r4ToR.";
$lang['adminexp_18'] = "<b>vi51tor l0G</b> 4llow\$ j00 +o VIew @n 3X+3ndeD L15t OF V1\$1TORS IncluD1N9 +heir h++p r3phER3r\$.";
$lang['createforumstyle'] = "cre4te 4 foruM styLe";
$lang['newstylesuccessfullycreated'] = "n3W \$tYL3 sUCCe\$SfuLLy Cre4+3D.";
$lang['stylealreadyexists'] = "a \$tYL3 W1TH +h4+ fiLeN@m3 4lr3ady ex1s+s.";
$lang['stylenofilename'] = "j00 d1d N0t ENt3r 4 fiLeN@m3 +O S4v3 tH3 STYLE w1th.";
$lang['stylenodatasubmitted'] = "could n0+ re4D PhoRUm \$TYLE d4t4.";
$lang['stylecontrols'] = "c0nTrol5";
$lang['stylecolourexp'] = "cl1ck 0N 4 Colour +o M4Ke 4 n3W stylE \$H3E+ 84SeD 0N +h4+ C0Lour. cUrreN+ B@se c0L0ur 1s F1r\$t 1n Li\$+.";
$lang['standardstyle'] = "st@nD@rD STYle";
$lang['rotelementstyle'] = "rOt@T3D El3m3nT \$TyL3";
$lang['randstyle'] = "raNdom \$+YL3";
$lang['thiscolour'] = "thI\$ C0LOUr";
$lang['enterhexcolour'] = "or enteR a hex coLoUR to 84s3 4 N3w \$+yl3 sH33+ 0N";
$lang['savestyle'] = "s4VE +hIs 5tYLE";
$lang['styledesc'] = "styl3 De\$Cr1p+i0n";
$lang['stylefilenamemayonlycontain'] = "styL3 FIL3N@M3 M4y 0nLy C0N+@in Low3rC4se L3T+er\$ (4-Z), NUm83R5 (0-9) 4Nd undErsC0re.";
$lang['stylepreview'] = "s+yLE prEv1eW";
$lang['welcome'] = "welcome";
$lang['messagepreview'] = "mE\$s@gE pR3V1Ew";
$lang['users'] = "u\$3R5";
$lang['usergroups'] = "us3R GRoups";
$lang['mustentergroupname'] = "j00 mu\$+ Ent3r @ Gr0up N4me";
$lang['profiles'] = "pR0fIl35";
$lang['manageforums'] = "m@n@9E PhOruMS";
$lang['forumsettings'] = "f0RuM \$eTt1n9\$";
$lang['globalforumsettings'] = "gLoB@L ph0Rum se+tin9s";
$lang['settingsaffectallforumswarning'] = "<b>nO+E:</b> +h353 S3tT1N9s @phfEc+ 4ll phORUmS. Wh3r3 the \$3TT1n9 is dUPl1cA+3d 0n +Eh 1nd1vIDu4l f0ruM'S \$ETtIN9s p4gE +ha+ w1ll +4k3 PreC3DeNcE oV3R Th3 5et+iN9S j00 ch4ngE H3r3.";
$lang['startpage'] = "st@r+ P4G3";
$lang['startpageerror'] = "s+@RT p@gE C0UlD Not 83 s@v3d. pl3aSe Try 494IN.";
$lang['uploadcssfile'] = "upLO4d C\$\$ s+yL3 \$H33+";
$lang['uploadcssfilefailed'] = "c\$\$ \$+yl3 \$h33t could N0+ 8e upLO@Ded. pleas3 tRy 4g41n.";
$lang['invalidfiletypeerror'] = "invAL1D F1LE typ3, j00 C4n 0nly upl0@D c\$S \$Tyle \$h3eT phil3s";
$lang['failedtoopenmasterstylesheet'] = "y0uR f0Rum Styl3 could n0+ b3 \$4V3D B3c4uS3 +He m4s+3r S+yLe \$h3e+ Could n0+ 8E l0@DeD. +o S4v3 your \$tyle th3 Ma\$+er STyle sh33t (m@k3_\$TyLe.c\$s) mU\$+ b3 L0c@t3d 1N +3h s+yL3\$ direcT0rY oPh y0ur 833H1v3 FORuM 1n5+@ll@t1on.";
$lang['makestyleerror'] = "y0UR pH0RUm 5TYL3 CouLd no+ 83 S4V3D l0c4Lly +O ThE seRVer 8Ec4u\$E p3rmis\$10N w4s d3nI3D.</p><p>to s4ve youR forum S+yL3 ple4\$E clicK tHE D0wNL04D bU+tON B3l0w wh1ch w1LL pr0mp+ j00 +0 s4v3 the ph1le tO yOur H4Rd DR1ve. j00 C@n TH3N upl04D tH1S ph1Le TO YOUr 5erV3R 1n+0 +3H foLLoWiN9 fOLder, if N3C3\$S4RY cr3a+1N9 TH3 PHOLd3r \$tRUCtUre IN thE prOC3sS.</p><p><b>%s</b></p><p>pLe4\$e nOt3 th4+ S0ME 8r0W\$Ers M@y CH4NGe +h3 n@Me 0f th3 F1l3 UPoN d0Wnlo4D. WhEN UpL0ad1NG +eh phiL3 pl3@\$e m4K3 Sur3 TH4t iT i\$ N4meD s+YLE.c5s OTH3RWiS3 TEh FORUm S+YLe WIlL B3 Un@V@1L4bl3.";
$lang['forumstyle'] = "f0Rum \$+yle";
$lang['wordfilter'] = "w0Rd phIl+eR";
$lang['forumlinks'] = "f0ruM liNKs";
$lang['viewlog'] = "v13W l0g";
$lang['noprofilesectionspecified'] = "n0 pr0fILe 5ec+10N \$Pec1pH13D.";
$lang['itemname'] = "i+3m n@ME";
$lang['moveto'] = "m0V3 tO";
$lang['manageprofilesections'] = "m@n493 prOFil3 S3c+ionS";
$lang['sectionname'] = "sECt10N N@mE";
$lang['items'] = "it3mS";
$lang['mustspecifyaprofilesectionid'] = "mUS+ \$PEcifY 4 pr0phiLe 53c+i0n 1d";
$lang['mustsepecifyaprofilesectionname'] = "mU\$+ \$p3c1PHY 4 pRof1LE s3Cti0n N4ME";
$lang['noprofilesectionsfound'] = "nO 3X1s+iNG Pr0FIL3 s3C+1oNS f0und. +o @Dd @ pr0F1le SEc+10N cl1cK t3h '@dD N3w' But+0N 83l0w.";
$lang['addnewprofilesection'] = "adD NEw pr0fiLe seC+1on";
$lang['successfullyaddedprofilesection'] = "suCCessPHuLlY 4ddeD prof1L3 sEcTiOn";
$lang['successfullyeditedprofilesection'] = "sUcce\$\$FulLY 3DI+3D pRophil3 \$ec+iON";
$lang['addnewprofilesection'] = "add new PRof1Le sec+10n";
$lang['mustsepecifyaprofilesectionname'] = "mUS+ Spec1pHy a Prof1l3 \$Ec+ion N4m3";
$lang['successfullyremovedselectedprofilesections'] = "suCcessPHully removEd 5El3c+Ed pR0phil3 \$EC+10ns";
$lang['failedtoremoveprofilesections'] = "f@Iled to R3MOVE pr0F1le SEC+10N\$";
$lang['viewitems'] = "vieW I+eMS";
$lang['successfullyaddednewprofileitem'] = "sUCCESSphully 4DDED n3W prof1l3 It3m";
$lang['successfullyeditedprofileitem'] = "sUcc3\$sphULly eD1teD proPh1LE i+3m";
$lang['successfullyremovedselectedprofileitems'] = "sucC3sSFuLLY R3moved 5El3C+eD proph1l3 IT3M\$";
$lang['failedtoremoveprofileitems'] = "faIl3d +0 reM0ve propH1l3 ITemS";
$lang['noexistingprofileitemsfound'] = "tHER3 4rE NO eX1sT1Ng pR0f1L3 I+3mS iN thiS s3C+ion. +0 aDd an 1t3M cl1ck T3h '4dd N3w' buT+0N B3l0W.";
$lang['edititem'] = "ediT 1tem";
$lang['invalidprofilesectionid'] = "inv4l1d pROf1le \$3c+IOn id 0r SeCTI0n NO+ ph0uND";
$lang['invalidprofileitemid'] = "iNV4l1d PR0PH1Le 1t3m 1d 0R 1T3M n0+ PHOuND";
$lang['addnewitem'] = "aDD N3W 1+eM";
$lang['youmustenteraprofileitemname'] = "j00 muS+ ENT3R 4 Pr0F1le i+3m n4mE";
$lang['invalidprofileitemtype'] = "iNv4l1d Pr0FILe it3M Type s3leC+3D";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 Mus+ 3NtEr SOM3 0ptI0NS phOr s3l3ctEd pR0phil3 1+em type";
$lang['youmustentermorethanoneoptionforitem'] = "j00 mus+ 3N+ER mor3 +han 0N3 0pt1on F0R \$El3C+3d pR0ph1le 1tem +Yp3";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "prOph1l3 IT3M hyperlINk5 \$UPP0RT ht+p uRLs 0nly";
$lang['profileitemhyperlinkformatinvalid'] = "pR0F1L3 i+3m HYP3rl1NK phoRm@+ inv@l1d";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 muST InCluD3 <i>%s</i> 1n TH3 url of Cl1ckAbl3 HYpErl1nK5";
$lang['failedtocreatenewprofileitem'] = "f41l3d tO crea+e N3W PR0fiLE it3m";
$lang['failedtoupdateprofileitem'] = "f4il3d tO uPd@+e pROf1LE 1t3m";
$lang['startpageupdated'] = "s+@r+ p4g3 upd@teD. %s";
$lang['cssfileuploaded'] = "css S+yl3 SH33+ upLO@dEd. %s";
$lang['viewupdatedstartpage'] = "vI3w upd@TED s+4rT P4G3";
$lang['editstartpage'] = "eD1T S+@r+ P4GE";
$lang['nouserspecified'] = "n0 U\$ER sp3cifi3d.";
$lang['manageuser'] = "m4N4G3 uS3R";
$lang['manageusers'] = "maN4Ge U\$3RS";
$lang['userstatusforforum'] = "u5eR s+@+us f0r %s";
$lang['userdetails'] = "u\$ER D3+A1Ls";
$lang['edituserdetails'] = "ed1+ U\$3R de+4il\$";
$lang['warning_caps'] = "warNin9";
$lang['userdeleteallpostswarning'] = "ar3 J00 \$uR3 j00 w@N+ +0 d3l3+3 4LL oPH the \$el3CtEd uSeR's P0S+\$? ONcE th3 Post\$ 4R3 d3let3D th3y C4NN0+ b3 re+r1eV3D 4nd w1ll 83 losT phOrEv3r.";
$lang['folderaccess'] = "fold3r 4ccES5";
$lang['possiblealiases'] = "p05s18LE 4li4\$e\$";
$lang['ipaddressmatches'] = "ip 4ddrESs m@+che\$";
$lang['emailaddressmatches'] = "em41l @dDres5 m4+Ches";
$lang['passwdmatches'] = "p4\$Sw0rd m@TcheS";
$lang['httpreferermatches'] = "httP R3phEr3r Ma+CHe\$";
$lang['userhistory'] = "user HIST0ry";
$lang['nohistory'] = "n0 HIs+0rY reCordS s@V3D";
$lang['userhistorychanges'] = "cH@NG3\$";
$lang['clearuserhistory'] = "cL34r uSEr hisT0RY";
$lang['changedlogonfromto'] = "ch@N93D loGOn PHrom %s +o %s";
$lang['changednicknamefromto'] = "ch4nged n1CKn4m3 froM %s +o %s";
$lang['changedemailfromto'] = "cH@n93d EM4iL fr0m %s +O %s";
$lang['successfullycleareduserhistory'] = "sUcc3s\$fULly Cle4R3D us3r h1s+0ry";
$lang['failedtoclearuserhistory'] = "fAILeD To Cl3@r user h1s+0RY";
$lang['successfullychangedpassword'] = "suCcesSPhully ch4ngeD PasSWorD";
$lang['failedtochangepasswd'] = "f@Il3D t0 chAn9E p@\$5w0rd";
$lang['approveuser'] = "appROV3 uSEr";
$lang['viewuserhistory'] = "v13W u5er Hist0Ry";
$lang['viewuseraliases'] = "vi3w U5Er @L1As3\$";
$lang['searchreturnednoresults'] = "s3@rCH rE+Urn3D no R3\$UltS";
$lang['deleteposts'] = "d3l3+e POs+S";
$lang['deleteuser'] = "dEL3Te uSER";
$lang['alsodeleteusercontent'] = "aLSo dele+e @Ll 0F +eh cON+eN+ Cr3@+3D 8Y +h1s US3R";
$lang['userdeletewarning'] = "aRE j00 5uRE j00 waNT tO Del3+3 +H3 SEl3C+ed Us3r 4Cc0Un+? oNC3 +h3 @cC0un+ h4\$ b33N d3lEt3d 1t c@NN0T 83 r3Trieved and w1ll B3 LOST phoreV3r.";
$lang['usersuccessfullydeleted'] = "u5eR sucC35sphUlly dEle+3d";
$lang['failedtodeleteuser'] = "f@iL3d +0 D3l3t3 US3r";
$lang['forgottenpassworddesc'] = "ipH +hIS U\$Er HAs ph0RGO+t3N thE1r p@5swORD J00 C4n rese+ 1t FOR +Hem heR3.";
$lang['failedtoupdateuserstatus'] = "f@il3d TO uPD4+3 User St@TU5";
$lang['failedtoupdateglobaluserpermissions'] = "f41l3d +0 Upd@+3 9lo8@L U\$eR p3rm1s\$iON\$";
$lang['failedtoupdatefolderaccesssettings'] = "f@iL3D to UpD4T3 phOLdEr 4cC3\$S \$E+T1NGs";
$lang['manageusersexp'] = "tH15 lIS+ sh0ws 4 \$eL3C+1on Of uSErs wHO Have lOG9ED 0n t0 yoUR Ph0Rum, \$0rTEd 8y %s. +O 4lT3r 4 u\$Er's permisS1Ons cl1cK +heir N4ME.";
$lang['userfilter'] = "u\$Er pH1lTEr";
$lang['withselected'] = "wI+H s3lecT3d";
$lang['onlineusers'] = "onlIN3 uS3Rs";
$lang['offlineusers'] = "opHFline UsERS";
$lang['usersawaitingapproval'] = "us3rS AW@1Tin9 appr0v4L";
$lang['bannedusers'] = "b4NN3d u\$Er\$";
$lang['lastlogon'] = "l4s+ L09On";
$lang['sessionreferer'] = "s3SSIon R3PhEr3r";
$lang['signupreferer'] = "sI9n-UP r3pher3r:";
$lang['nouseraccountsmatchingfilter'] = "n0 uSEr 4CC0Un+S m4+cHin9 ph1LT3r";
$lang['searchforusernotinlist'] = "s34rCH foR 4 u\$3r N0+ in lI\$T";
$lang['adminaccesslog'] = "aDm1n 4cc3\$S l09";
$lang['adminlogexp'] = "tHiS lIS+ SHows +He l4st @CTi0NS S@nC+IoNed by uSers wITh 4DmIN PR1viL3G3s.";
$lang['datetime'] = "d@+3/+1me";
$lang['unknownuser'] = "uNkNOwn u\$er";
$lang['unknownuseraccount'] = "unknowN u\$3R @CCoun+";
$lang['unknownfolder'] = "uNkNOwn f0ld3R";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l@sT IP @ddrEsS";
$lang['logged'] = "l09ged";
$lang['notlogged'] = "no+ l0gg3D";
$lang['addwordfilter'] = "adD W0rD ph1lt3r";
$lang['addnewwordfilter'] = "aDD n3w W0rd ph1l+3r";
$lang['wordfilterupdated'] = "wOrd fIL+ER uPd4+3D";
$lang['wordfilterisfull'] = "j00 c@nnO+ @dd @nY mORe WORd Phil+erS. Rem0VE \$0me unUseD ON3\$ OR 3Dit +h3 3xIS+1Ng 0NE5 fir\$T.";
$lang['filtername'] = "fil+er NaMe";
$lang['filtertype'] = "f1l+ER tYPe";
$lang['filterenabled'] = "f1Lt3r en48LED";
$lang['editwordfilter'] = "eD1+ w0RD phiL+3R";
$lang['nowordfilterentriesfound'] = "n0 3x1s+Ing WorD ph1lter entr1ES founD. t0 4Dd 4 f1ltEr CL1cK Th3 '4dd N3w' 8u++0N B3low.";
$lang['mustspecifyfiltername'] = "j00 Must Sp3C1Phy 4 f1l+er n@m3";
$lang['mustspecifymatchedtext'] = "j00 mu\$t 5P3cify M4+ChEd texT";
$lang['mustspecifyfilteroption'] = "j00 must Spec1FY 4 Phil+er oP+10n";
$lang['mustspecifyfilterid'] = "j00 MU5t SPecIFY @ ph1l+er id";
$lang['invalidfilterid'] = "iNV4lid PHilter 1d";
$lang['failedtoupdatewordfilter'] = "f@iLEd +0 upd4T3 wORd ph1lt3R. Ch3cK +h@t +3H f1L+3r ST1ll ex1sT\$.";
$lang['allow'] = "aLL0w";
$lang['block'] = "bl0cK";
$lang['normalthreadsonly'] = "norM@l +hr34Ds 0nly";
$lang['pollthreadsonly'] = "pOLL tHR3ADS ONly";
$lang['both'] = "b0+H +hre4d +yp3s";
$lang['existingpermissions'] = "exIs+1n9 p3rm1\$s1oNS";
$lang['nousershavebeengrantedpermission'] = "no ExisT1N9 Us3r\$ p3rm1\$s1oNs FOund. +O gR4n+ P3RM15Si0n +o Us3rs \$E4RcH Ph0r +h3m b3l0W.";
$lang['successfullyaddedpermissionsforselectedusers'] = "succ3sSFullY AdDED p3rm1\$S1OnS ph0r \$3Lec+ED u\$Ers";
$lang['successfullyremovedpermissionsfromselectedusers'] = "suCC3ssFuLLY r3mov3d PeRmI\$s1oN\$ fr0m SeLEC+3d US3Rs";
$lang['failedtoaddpermissionsforuser'] = "f@IL3d to 4DD pErm1\$sion\$ F0R u\$3R '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f4il3D +o rEmove p3rm1ssIOns PhroM us3r '%s'";
$lang['searchforuser'] = "sE4Rch F0R uS3R";
$lang['browsernegotiation'] = "broWser NE90tI4+3d";
$lang['textfield'] = "teXt f1elD";
$lang['multilinetextfield'] = "mULT1-liN3 TEx+ f1eld";
$lang['radiobuttons'] = "r4d10 bU+t0nS";
$lang['dropdownlist'] = "dr0p D0Wn li\$t";
$lang['clickablehyperlink'] = "cL1CK4bl3 hyp3rl1nk";
$lang['threadcount'] = "tHre4D c0unt";
$lang['clicktoeditfolder'] = "clIcK +o 3d1t pHOlDer";
$lang['fieldtypeexample1'] = "t0 cR34T3 r4d1o 8UT+0nS 0r 4 droP dOWN l1s+ j00 neEd +0 enteR eACh 1nDiviDuAL vaLU3 on 4 \$Ep@r4+3 LIne in teh op+iONs f13ld.";
$lang['fieldtypeexample2'] = "to CR3@+e cL1ck48L3 L1NkS 3ntEr teh Url iN tEh 0PTi0Ns Ph1ELD 4nd uS3 <i>%1\$s</i> WH3r3 TH3 en+rY froM +H3 U\$3R's pROfil3 \$h0Uld 4PP3AR. ex4mpl3\$: <p>mYsP4c3: <i>h++p://wWW.MYSP@cE.c0M/%1\$s</i><br />xBoX l1ve: <i>h+TP://PRopH1Le.mY94Merc4RD.net/%1\$\$</i></p>";
$lang['editedwordfilter'] = "eD1t3d wORd Ph1l+3R";
$lang['editedforumsettings'] = "edi+eD Ph0RUm sE+tIN9S";
$lang['successfullyendedusersessionsforselectedusers'] = "suCc35sfullY 3Nd3d SE5S10N\$ ph0r 53LEC+3D uSERS";
$lang['failedtoendsessionforuser'] = "f4Il3D TO EnD \$ES5Ion PH0r US3r %s";
$lang['successfullyapproveduser'] = "succEs\$fully appr0veD U5Er";
$lang['successfullyapprovedselectedusers'] = "sUCC3sspHUlLY appROv3D sel3C+ed USeRS";
$lang['matchedtext'] = "m@+ch3d t3x+";
$lang['replacementtext'] = "r3pL@c3m3nt text";
$lang['preg'] = "pR3g";
$lang['wholeword'] = "wh0l3 WOrd";
$lang['word_filter_help_1'] = "<b>all</b> M@+Ch3\$ a9@1N5t Th3 whol3 +3xt s0 FilT3RIn9 Mom TO mum w1ll 4LSo ch4Nge m0ment +O mUmen+.";
$lang['word_filter_help_2'] = "<b>wHoLE woRd</b> mA+Ch3\$ Ag41N\$T WH0L3 WORD\$ ONlY 50 filt3rINg mom To mUM Will No+ ch@ngE m0mEn+ +O mumen+.";
$lang['word_filter_help_3'] = "<b>prEG</b> 4LL0w5 j00 +0 USE P3rl RE9Ul4R 3XPr3s5iONs +0 m4tcH +3xT.";
$lang['nameanddesc'] = "n4me 4Nd D3SCRipTION";
$lang['movethreads'] = "mOvE +hre4Ds";
$lang['movethreadstofolder'] = "m0v3 THreads +0 f0LDEr";
$lang['failedtomovethreads'] = "f41LEd +0 mOv3 thre4Ds To SP3C1PH13d FOLd3R";
$lang['resetuserpermissions'] = "reSE+ u\$3r p3rm1s\$10n\$";
$lang['failedtoresetuserpermissions'] = "f4IL3d To R3\$E+ user p3rm1\$s10nS";
$lang['allowfoldertocontain'] = "aLl0w fOLdER tO Cont4in";
$lang['addnewfolder'] = "aDd n3W Folder";
$lang['mustenterfoldername'] = "j00 MU\$T 3nteR 4 Ph0lD3r n@M3";
$lang['nofolderidspecified'] = "n0 FOlder 1d \$PEcipH13D";
$lang['invalidfolderid'] = "iNvalId ph0lD3R 1d. ChEck tha+ 4 pholder W1+h This Id ex1sTS!";
$lang['folderdisplayorderthreadsbyfolderview'] = "f0LD3r 0rd3r onLy 4pplIE\$ WHeN Us3r ha\$ En@8lEd '50r+ +HR34d l1St By PhoLd3R\$' In fOrum op+1ONs.";
$lang['successfullyaddednewfolder'] = "suCC3\$sfully ADD3d N3w phOLd3R";
$lang['successfullyremovedselectedfolders'] = "sUcc3s\$fULLY R3moved sel3C+eD F0LDers";
$lang['successfullyeditedfolder'] = "sUCCEsSPhulLY Ed1+ed FOlDeR";
$lang['failedtocreatenewfolder'] = "f4IlEd t0 cR3@+3 new ph0lD3r";
$lang['failedtodeletefolder'] = "fa1LED t0 DEL3+3 folder.";
$lang['failedtoupdatefolder'] = "f4IleD +0 uPd@T3 foldEr";
$lang['cannotdeletefolderwiththreads'] = "c@NN0+ del3+e folDerS tH4+ 5till C0n+4in +hre@ds.";
$lang['forumisnotsettorestrictedmode'] = "fOrum is no+ S3+ +0 r3\$TRICt3D mod3. do j00 w4nT to En@8lE 1+ NoW?";
$lang['forumisnotsettopasswordprotectedmode'] = "fOrum I\$ n0T \$Et to P@s\$WORd pro+eC+ed MoD3. do J00 w@n+ to en48l3 1T n0w?";
$lang['groups'] = "groUP\$";
$lang['nousergroups'] = "n0 U\$3R gROups h4v3 833n Se+ up. +o 4Dd A 9ROuP cL1Ck +h3 '4Dd new' BUt+0n Bel0w.";
$lang['suppliedgidisnotausergroup'] = "sUpPLieD 9ID 1\$ n0+ A USeR 9ROuP";
$lang['manageusergroups'] = "m4n4ge U53R 9r0ups";
$lang['groupstatus'] = "grOup stA+us";
$lang['addusergroup'] = "aDD user 9R0UP";
$lang['addemptygroup'] = "add 3mp+y 9r0up";
$lang['adduserstogroup'] = "adD Users to group";
$lang['addremoveusers'] = "add/R3M0v3 u\$ERS";
$lang['nousersingroup'] = "th3Re @re n0 USEr5 1N thI\$ gR0Up. 4Dd user5 +0 +H1S grouP 8Y SEarchIn9 pHOR +hem b3LoW.";
$lang['groupaddedaddnewuser'] = "sUcce5spHUlly 4ddeD 9roup. 4Dd u5Ers T0 this gr0up By S34Rch1ng ph0r tH3m b3L0W.";
$lang['nousersingroupaddusers'] = "tHeRE @R3 No u\$3Rs iN This 9roUP. TO 4dD U\$eR\$ cl1Ck th3 '4dd/REmove u\$Ers' bUT+0n 8EloW.";
$lang['useringroups'] = "tH1s U\$Er 1s 4 m3mbEr oPH +he PHollow1ng gr0upS";
$lang['usernotinanygroups'] = "tHi\$ U\$3r 1\$ N0+ 1N 4ny UseR gR0UPS";
$lang['usergroupwarning'] = "n0+3: +h1\$ u\$3r M@Y 83 Inher1+1ng ADD1ti0n4L P3rmiSS10Ns From AnY U\$3r 9r0UPS liSt3d 83l0W.";
$lang['successfullyaddedgroup'] = "suCC3s\$fulLY @DdeD GR0uP";
$lang['successfullyeditedgroup'] = "sUccESSfulLY Ed1+3d 9roUP";
$lang['successfullydeletedselectedgroups'] = "sucCes\$fUlLY D3l3TEd \$ElEc+3D 9r0uPS";
$lang['failedtodeletegroupname'] = "f4Il3d t0 dEl3+e GR0uP %s";
$lang['usercanaccessforumtools'] = "u5Er c4n 4CCes5 ph0Rum tOOl\$ 4nd C4n creat3, d3l3+e @nd 3d1T pH0Rums";
$lang['usercanmodallfoldersonallforums'] = "u5er c4n MOd3R@+3 <b>aLl PholdErs</b> 0N <b>aLl F0RUm\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "u\$3r c4N m0d3R4+E l1nks S3C+ion 0n <b>aLL f0Rums</b>";
$lang['emailconfirmationrequired'] = "eM@1L c0nfIrm4+i0n REqu1R3d";
$lang['userisbannedfromallforums'] = "u53r i\$ B4NNed pHRom <b>all FORum5</b>";
$lang['cancelemailconfirmation'] = "c4NCEl Em4il c0npHIrm@+1on 4nD @lloW user +0 ST@rt PosTin9";
$lang['resendconfirmationemail'] = "reSend conf1rm4t1on em@1l to uSeR";
$lang['failedtosresendemailconfirmation'] = "f4Il3D T0 Res3nd em4il c0NFirM@TIOn to U53R.";
$lang['donothing'] = "do no+Hin9";
$lang['usercanaccessadmintools'] = "useR h@S acC3Ss +0 F0rUM @DmIN TooLS";
$lang['usercanaccessadmintoolsonallforums'] = "u5er H4S 4cC3SS +0 4DmiN TOoLS <b>on 4LL f0rum\$</b>";
$lang['usercanmoderateallfolders'] = "u53R c4N M0d3r4+e @ll PHoldeRS";
$lang['usercanmoderatelinkssection'] = "u\$3r c4n m0D3r@Te l1nk\$ sec+10n";
$lang['userisbanned'] = "u5ER 1S 84nN3D";
$lang['useriswormed'] = "u\$3R 1S W0RMeD";
$lang['userispilloried'] = "u\$3R 1S p1llOrIed";
$lang['usercanignoreadmin'] = "uS3r C4N 1gn0re @dmin1s+R4torS";
$lang['groupcanaccessadmintools'] = "groUp c4n @cCE\$S @dmin t00L\$";
$lang['groupcanmoderateallfolders'] = "gr0Up c4N MoD3r@T3 aLL pholdeR\$";
$lang['groupcanmoderatelinkssection'] = "gROuP c4N M0d3r4t3 LINks \$ECt10N\$";
$lang['groupisbanned'] = "gR0UP iS 84nn3d";
$lang['groupiswormed'] = "gR0UP 1s Worm3d";
$lang['readposts'] = "rE@d po\$+s";
$lang['replytothreads'] = "rEPly t0 ThRead\$";
$lang['createnewthreads'] = "cr34+E neW tHr34Ds";
$lang['editposts'] = "eDit P0s+S";
$lang['deleteposts'] = "d3l3te Pos+\$";
$lang['postssuccessfullydeleted'] = "p0S+s wEr3 \$UcCeS5fulLY d3l3+3D";
$lang['failedtodeleteusersposts'] = "fa1L3d t0 D3LE+e u5eR'5 p0s+S";
$lang['uploadattachments'] = "upLO4D @+t4CHM3N+S";
$lang['moderatefolder'] = "m0D3RA+e f0LD3R";
$lang['postinhtml'] = "p0St 1n html";
$lang['postasignature'] = "pO\$t 4 \$1GN@Ture";
$lang['editforumlinks'] = "eDI+ pH0RUm l1nkS";
$lang['linksaddedhereappearindropdown'] = "liNKS @Dded h3r3 @ppe4r iN 4 drop d0wn In t3h top Ri9h+ Oph the FR4m3 5E+.";
$lang['linksaddedhereappearindropdownaddnew'] = "linKS 4dd3D H3R3 appear 1N @ dr0p down in t3H T0P riGh+ oF +HE FR@M3 set. TO @Dd @ link cliCk TH3 '@Dd n3w' bu++on beL0W.";
$lang['failedtoremoveforumlink'] = "f41l3d tO rEMOv3 fORum link '%s'";
$lang['failedtoaddnewforumlink'] = "f4iL3D TO 4Dd nEw FOrum liNK '%s'";
$lang['failedtoupdateforumlink'] = "f@iLED +0 upd@+3 Forum lINk '%s'";
$lang['notoplevellinktitlespecified'] = "no +OP lev3l LINk ti+LE sP3c1fieD";
$lang['youmustenteralinktitle'] = "j00 Mu\$+ en+3r @ LInK +1+le";
$lang['alllinkurismuststartwithaschema'] = "alL LInk Uris mu\$t ST@RT with 4 SCh3M@ (1.3. ht+p://, ftp://, 1Rc://)";
$lang['editlink'] = "edIt L1NK";
$lang['addnewforumlink'] = "add nEW ph0RUm LInk";
$lang['forumlinktitle'] = "foRUm LINK +ItlE";
$lang['forumlinklocation'] = "f0rUm lINk l0ca+1on";
$lang['successfullyaddednewforumlink'] = "sUcC3S\$fully @Dd3d new Ph0ruM Link";
$lang['successfullyeditedforumlink'] = "successPhully EdIT3D phorum l1nk";
$lang['invalidlinkidorlinknotfound'] = "inV4L1D LInK 1d Or lINk n0+ phOUnD";
$lang['successfullyremovedselectedforumlinks'] = "sUCc35SFuLlY rem0vEd seleC+eD L1nkS";
$lang['toplinkcaption'] = "t0P l1nk capti0n";
$lang['allowguestaccess'] = "alL0w gu3\$T 4Cc35s";
$lang['searchenginespidering'] = "sE4RCH 3N91N3 spId3R1ng";
$lang['allowsearchenginespidering'] = "alL0W s3arch 3ng1n3 SP1d3riN9";
$lang['showsearchenginebotsinvisitors'] = "sH0w se4rch 3N91n3 8O+s IN v1S1T0r log";
$lang['showsearchenginebotsinactiveusers'] = "sH0W \$Earch 3n91NE 80Ts 1n 4C+1v3 user5";
$lang['sitemapenabled'] = "en@Bl3 s1+3m4p";
$lang['sitemapupdatefrequency'] = "si+3MAp uPD4+3 Fr3qu3ncY";
$lang['sitemappathnotwritable'] = "s1+Em@P D1reC+0RY Mus+ 83 Writa8L3 8Y tEh we8 server / php proc3\$s!";
$lang['newuserregistrations'] = "n3w uS3R re9IstR4T10Ns";
$lang['preventduplicateemailaddresses'] = "pr3VEnT duplic4te 3M41L @Ddr3\$S3s";
$lang['allownewuserregistrations'] = "alL0w neW uSer re91Str4tiONS";
$lang['requireemailconfirmation'] = "r3qu1R3 EM@1L c0Nphirm4t10N";
$lang['usetextcaptcha'] = "u\$3 teXt-c4ptCh4";
$lang['textcaptchafonterror'] = "t3xt-C@ptch4 h4s 833N diS4bL3d @U+Om4+1C4lly b3c4U\$e +h3r3 4r3 n0 tru3 typE PHont\$ 4v@1L48L3 fOR 1T +O U\$E. pl3a\$E UPl0@d \$om3 TRuE +YP3 PhonT\$ +o <b>tExT_c4p+Ch@/foNTs</b> 0n y0ur \$erver.";
$lang['textcaptchadirerror'] = "t3xt-c@p+Cha h4\$ 8eEn D1S4Bl3D 83C@us3 +h3 texT_c@P+Ch@ D1R3ctORy @nD 1t'S sub-direcTor13\$ 4re not WR1T@Bl3 8Y +h3 Web s3rveR / php PRocES\$.";
$lang['textcaptchagderror'] = "t3Xt-C4PTCh4 H@s 8E3n dis4Bl3d 83C@us3 y0uR \$erVER's PHp S3+uP d03\$ n0+ pr0v1De suppoRT foR 9d im493 M@nIPUl4+10n 4Nd / or ++f f0n+ supp0r+. 80+H @R3 rEqu1R3D pHOr +exT-C@P+Cha 5UPp0rt.";
$lang['newuserpreferences'] = "n3W us3r pr3pher3ncEs";
$lang['sendemailnotificationonreply'] = "em@IL N0+1FIc4+ion ON repLY +o User";
$lang['sendemailnotificationonpm'] = "eM41l nO+1f1c4TI0n ON pm To u\$3r";
$lang['showpopuponnewpm'] = "sH0w POPUp WH3N R3c3ivin9 n3w pM";
$lang['setautomatichighinterestonpost'] = "sEt @U+om@+ic hI9h 1N+3res+ on p0s+";
$lang['postingstats'] = "pO\$tin9 s+4+s";
$lang['postingstatsforperiod'] = "po\$t1NG ST@ts phoR p3rIOd %s To %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 p0St d4t4 RecORD3D phoR +H15 p3r10D.";
$lang['totalposts'] = "t0T4L PO\$TS";
$lang['totalpostsforthisperiod'] = "t0T@l pO\$+\$ ph0r th1s P3r10D";
$lang['mustchooseastartday'] = "mu\$+ ch0ose 4 S+4rt d4y";
$lang['mustchooseastartmonth'] = "mu\$+ choo\$E 4 5+4R+ m0NTh";
$lang['mustchooseastartyear'] = "mus+ ch0oSE 4 STar+ ye4r";
$lang['mustchooseaendday'] = "muS+ ch00SE @N 3nD d4Y";
$lang['mustchooseaendmonth'] = "mu\$+ choo\$3 4n 3nD MOn+h";
$lang['mustchooseaendyear'] = "mU5+ ch0OSe @n 3nd yE@R";
$lang['startperiodisaheadofendperiod'] = "sT4r+ P3Riod 1s 4head of 3nd P3R10D";
$lang['bancontrols'] = "b4N CON+rols";
$lang['addban'] = "add B@N";
$lang['checkban'] = "checK baN";
$lang['editban'] = "eD1t 84N";
$lang['bantype'] = "b4N tyPe";
$lang['bandata'] = "b4n D4T@";
$lang['banexpires'] = "b4n 3Xp1r3\$";
$lang['bancomment'] = "cOmm3N+";
$lang['optionalbrackets'] = "(opTIOn4l)";
$lang['ipban'] = "ip 84N";
$lang['logonban'] = "l0G0N B4N";
$lang['nicknameban'] = "n1CKn4m3 8aN";
$lang['emailban'] = "eM@1l 84N";
$lang['refererban'] = "refer3r b@n";
$lang['invalidbanid'] = "iNv4l1D b4n 1D";
$lang['affectsessionwarnadd'] = "tH1\$ 84N m4y 4phFEc+ +he PHoLLOw1N9 @cTIve user sE\$S10nS";
$lang['noaffectsessionwarn'] = "th1S bAn @phph3Cts no aC+ive s3\$SI0ns";
$lang['mustspecifybantype'] = "j00 MuS+ \$pEc1Phy 4 8An typ3";
$lang['mustspecifybandata'] = "j00 mu\$t SP3C1pHY s0me B4n DaT4";
$lang['expirydateisinvalid'] = "eXP1rY D4+3 1s Inv@l1D";
$lang['successfullyremovedselectedbans'] = "succ3s5fully remoVED \$3LEct3D 84nS";
$lang['failedtoaddnewban'] = "f@IL3d +0 4DD N3w bAn";
$lang['failedtoremovebans'] = "f@il3D +o rEM0VE S0m3 0r 4ll 0ph +h3 \$eL3Ct3d B@nS";
$lang['duplicatebandataentered'] = "dUpLIc@te 8@n d4t@ enTeR3d. Pl3@s3 cH3Ck y0uR WILDCarDs +0 S33 if th3y 4lrE@dy m4tCh THe d@ta 3nt3r3D";
$lang['successfullyaddedban'] = "suCCessPHully 4DdeD 84n";
$lang['successfullyupdatedban'] = "sUcc3s5fully UPd4TEd 84N";
$lang['noexistingbandata'] = "thERe i\$ n0 existIN9 Ban d@t4. +o 4dD 4 baN CL1Ck th3 '4dd neW' 8UT+on beL0W.";
$lang['youcanusethepercentwildcard'] = "j00 c4n u\$e t3H p3rc3n+ (%) wiLDc@rd \$yMb0l 1n @ny oPH Y0ur 84N LiST\$ +0 ob+@1n P4Rti4l ma+Ch3\$, 1.E. '192.168.0.%' WOULd b4n @lL 1P @dDR35SE\$ 1n tH3 R4n9e 192.168.0.1 thr0ugh 192.168.0.254";
$lang['selecteddateisinthepast'] = "s3L3CTeD d4+e is In +H3 P4S+";
$lang['cannotusewildcardonown'] = "j00 C4NNOT 4dd % 4\$ a w1ldCard m@tCH oN 1t\$ oWn!";
$lang['requirepostapproval'] = "r3QU1re p0S+ @PProV4l";
$lang['adminforumtoolsusercounterror'] = "tHeR3 mu\$+ b3 4+ lE@5T 1 U5ER wITH 4DM1n +o0l\$ aNd ph0rUm +O0LS @cCEs5 on all Ph0rums!";
$lang['postcount'] = "p0St c0Unt";
$lang['changepostcount'] = "ch4nGe P0S+ c0UNt";
$lang['resetpostcount'] = "re\$e+ PoS+ C0un+";
$lang['successfullyresetpostcount'] = "sUCc3SspHulLy Re\$eT po5t coUn+";
$lang['successfullyupdatedpostcount'] = "sUcCEs\$fUlLY UpD4+3d pos+ c0UN+";
$lang['failedtoresetuserpostcount'] = "f@1leD +0 reS3t P0\$t C0Un+";
$lang['failedtochangeuserpostcount'] = "f4Il3d t0 ch@n9e user POST c0UNt";
$lang['postapprovalqueue'] = "p0S+ @Ppr0v4l qu3u3";
$lang['nopostsawaitingapproval'] = "n0 p0sT\$ 4R3 4waITiN9 @ppr0v4L";
$lang['failedtoapproveuser'] = "f@iLED +0 @PpROVe user %s";
$lang['endsession'] = "eND SEs510N (k1CK)";
$lang['visitorlog'] = "viS1T0r Log";
$lang['novisitorslogged'] = "nO V1s1+0rs L0g9eD";
$lang['addselectedusers'] = "add \$3LEC+ed u5Er5";
$lang['removeselectedusers'] = "r3Mov3 5el3c+3d uS3rS";
$lang['addnew'] = "adD nEw";
$lang['deleteselected'] = "deLE+3 SEleCt3d";
$lang['forumrulesmessage'] = "<p><b>f0rUM ruLEs</b></p><p>r391s+r4+1on +0 %1\$\$ is PHree! we d0 1ns1s+ TH4t j00 @8iD3 By t3h rul3s 4nd PolIC1ES DEt@1led 8EloW. if J00 @9R33 +o +he +erms, pLE@SE CHecK +3h '1 @9r3e' cheCkb0x And pr3\$s t3h 'R39i5teR' Bu++0n 8elow. IF j00 w0UlD lIk3 tO c4nc3L +h3 r3g1s+r4TIOn, cLIcK %2\$5 To RE+UrN +O th3 FoRUM\$ iNDEX.</p><p>aL+H0UGh Th3 4Dm1nIsTR4T0R5 AnD MODER@+0rS 0PH %1\$s W1lL 4T+3mpT +o Ke3P All 0bJEc+I0N4Bl3 M3\$s493\$ OfpH TH1S pH0rUM, 1t Is iMP0Ss1bl3 For U\$ T0 rEv13W 4lL me\$S@g3S. @ll m3\$S49E\$ 3XpREs\$ TEh V1eWs oF th3 4uThoR, @ND N3I+H3r +h3 0WN3r\$ 0PH %1\$S, NOR ProjEC+ 8E3h1V3 foRUM 4nd 1Ts @fpHilI4+35 w1lL 83 HELd REsP0nSI8LE For +h3 C0n+3N+ Of @nY m3S549e.</p><p>bY @9r33iN9 +O ThE\$e rul3\$, j00 wARr4n+ +h@+ J00 WilL n0+ P0\$+ 4nY M35\$4G3s +H4t @R3 08sceNE, vULG@R, SEXu4Lly-ORienT@+3D, h4t3Phul, +hr3@+3n1Ng, 0r otHERw1s3 In ViOl4tIoN OF @ny l4Ws.</p><p>tH3 0WnErS 0f %1\$\$ rES3Rve TH3 ri9h+ T0 r3m0vE, ED1t, m0ve 0r ClosE 4nY +HRE4d For 4nY R3@\$ON.</p>";
$lang['cancellinktext'] = "herE";
$lang['failedtoupdateforumsettings'] = "f@Iled tO upD@TE forum \$e+t1NGS. pleaSE TRY 4G@1n l@tEr.";
$lang['moreadminoptions'] = "mOr3 @dm1n Op+10ns";
$lang['mailfunction'] = "maIl phunCtion";
$lang['smtpserveraddr'] = "sm+P Server 4DdR3\$s";
$lang['smtpserverport'] = "sMtp S3RVeR P0RT";
$lang['smtpserverusername'] = "sm+P sERVEr u\$eRN4m3";
$lang['smtpserverpassword'] = "sm+P \$erver Pa\$sw0rD";
$lang['sendmailpath'] = "s3Ndm41l P@th";
$lang['phpmailfunction'] = "us3 pHP ma1l phUNC+IOn";
$lang['smtpmailserver'] = "u5E SM+P 53rV3R";
$lang['sendmail'] = "u\$3 Sendm4iL";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cHaN93D u\$eR ST@tu\$ f0r '%s'";
$lang['changedpasswordforuser'] = "cH4ng3D P@ssw0rD Ph0R '%s'";
$lang['changedforumaccess'] = "ch4nGED foRUm 4cCes\$ p3rmi5\$Ions F0R '%s'";
$lang['deletedallusersposts'] = "d3Le+Ed 4Ll P0\$+\$ PH0r '%s'";

$lang['createdusergroup'] = "cr34tEd uS3r GROup '%s'";
$lang['deletedusergroup'] = "d3L3+Ed uSEr group '%s'";
$lang['updatedusergroup'] = "uPd@+3d us3R gR0up '%s'";
$lang['addedusertogroup'] = "adDEd usEr '%s' tO 9ROUp '%s'";
$lang['removeduserfromgroup'] = "r3M0v3 usER '%s' phROm 9rouP '%s'";

$lang['addedipaddresstobanlist'] = "aDd3d 1p '%s' to 84n l1sT";
$lang['removedipaddressfrombanlist'] = "r3MovEd 1p '%s' FroM b4n l1sT";

$lang['addedlogontobanlist'] = "aDDEd L0GON '%s' +0 84N L1\$+";
$lang['removedlogonfrombanlist'] = "r3MovEd L0GoN '%s' phRom B4N l1S+";

$lang['addednicknametobanlist'] = "add3D NiCkn4m3 '%s' tO 8@n l1st";
$lang['removednicknamefrombanlist'] = "rem0Ved n1ckn4me '%s' Fr0M b4N l1st";

$lang['addedemailtobanlist'] = "added em@il 4DdR3s\$ '%s' +O 8AN LIst";
$lang['removedemailfrombanlist'] = "rEMoveD Em41L @ddReSS '%s' fr0m 84n LisT";

$lang['addedreferertobanlist'] = "aDded REfER3R '%s' to BAn L1\$+";
$lang['removedrefererfrombanlist'] = "rEMOV3D rEpher3r '%s' fr0m ban list";

$lang['editedfolder'] = "edI+3D PH0Ld3r '%s'";
$lang['movedallthreadsfromto'] = "mOv3D 4ll +HRe4DS frOM '%s' t0 '%s'";
$lang['creatednewfolder'] = "cR3@+3d N3w F0ld3r '%s'";
$lang['deletedfolder'] = "d3l3teD FoldeR '%s'";

$lang['changedprofilesectiontitle'] = "cH@n93D PROf1Le sec+10N +1+le from '%s' +o '%s'";
$lang['addednewprofilesection'] = "aDded NeW proF1le SEc+ioN '%s'";
$lang['deletedprofilesection'] = "dEleteD proFIl3 secT1on '%s'";

$lang['addednewprofileitem'] = "aDd3D n3W pR0ph1le item '%s' TO S3cTioN '%s'";
$lang['changedprofileitem'] = "cH@N9ED Pr0fil3 1+EM '%s'";
$lang['deletedprofileitem'] = "deLE+ED Prof1Le I+3m '%s'";

$lang['editedstartpage'] = "edi+3d START PAGe";
$lang['savednewstyle'] = "s4v3d NeW s+Yle '%s'";

$lang['movedthread'] = "m0VEd +Hr34d '%s' fR0M '%s' +o '%s'";
$lang['closedthread'] = "cLosed thRE4D '%s'";
$lang['openedthread'] = "oPenEd +hRE@d '%s'";
$lang['renamedthread'] = "r3N4med +hRe4d '%s' +0 '%s'";

$lang['deletedthread'] = "d3LEt3d +HR34D '%s'";
$lang['undeletedthread'] = "unD3L3+ed THReAd '%s'";

$lang['lockedthreadtitlefolder'] = "locked THrE4D 0Pt1onS on '%s'";
$lang['unlockedthreadtitlefolder'] = "unL0Cked thReAd opt1ons On '%s'";

$lang['deletedpostsfrominthread'] = "dEL3+ed posTS fr0M '%s' iN thR3@d '%s'";
$lang['deletedattachmentfrompost'] = "delE+3D 4++4chm3nt '%s' FRoM P0\$+ '%s'";

$lang['editedforumlinks'] = "eDIt3D pH0rum l1nkS";
$lang['editedforumlink'] = "ed1+3D ph0rum link: '%s'";

$lang['addedforumlink'] = "aDD3D fOrum L1nk: '%s'";
$lang['deletedforumlink'] = "d3L3+3d Ph0ruM l1nk: '%s'";
$lang['changedtoplinkcaption'] = "chAn93d +op Link C4P+IOn pHR0m '%s' to '%s'";

$lang['deletedpost'] = "dEl3t3D PosT '%s'";
$lang['editedpost'] = "edIt3d p0st '%s'";

$lang['madethreadsticky'] = "maDe +Hre4d '%s' sTICky";
$lang['madethreadnonsticky'] = "m@d3 tHReaD '%s' n0n-S+1Cky";

$lang['endedsessionforuser'] = "eNdEd SEs\$10N Phor usER '%s'";

$lang['approvedpost'] = "apProV3d POS+ '%s'";

$lang['editedwordfilter'] = "eD1ted word phil+3r";

$lang['addedrssfeed'] = "aDd3d r\$s phEed '%s'";
$lang['editedrssfeed'] = "edi+3d R5S ph33D '%s'";
$lang['deletedrssfeed'] = "d3l3teD rSs Ph3ed '%s'";

$lang['updatedban'] = "uPd@+3d 84N '%s'. ch@n9Ed typ3 phr0m '%s' +o '%s', cH4n93d d4t4 Phr0m '%s' to '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPLI+ +hr3@d '%s' @+ p0S+ %s  1N+0 New +hR34d '%s'";
$lang['mergedthreadintonewthread'] = "m3R93d tHR3@d\$ '%s' 4nd '%s' 1n+O NEw tHR3@d '%s'";

$lang['ipaddressbanhit'] = "uSEr '%s' 1S 84nNed. 1p adDress '%s' M4tched b4n d4T4 '%s'";
$lang['logonbanhit'] = "u53R '%s' iS 8@NN3d. LO9ON '%s' m4TcH3d b4n d@t@ '%s'";
$lang['nicknamebanhit'] = "us3R '%s' 1\$ B@nN3D. NIcKn@ME '%s' M@tCHed B@n D4t4 '%s'";
$lang['emailbanhit'] = "u\$3R '%s' i\$ 84nNED. EM@1l AdDR3\$\$ '%s' m4+cH3d 8aN d@+4 '%s'";
$lang['refererbanhit'] = "u\$3r '%s' is 8@Nn3D. h+tp repherEr '%s' MA+ChEd 8@N da+4 '%s'";

$lang['modifiedpermsforuser'] = "m0dIF1ED p3rM\$ PH0r User '%s'";
$lang['modifiedfolderpermsforuser'] = "m0d1f1ed phold3r perm\$ phor U\$ER '%s'";

$lang['deleteduseraccount'] = "d3LE+ed u5er aCC0un+ '%s'";
$lang['deletedalluserdataforaccount'] = "dEl3+Ed @Ll user d4t4 PH0R 4CC0uN+ '%s'";

$lang['userpermfoldermoderate'] = "fOLDEr m0der4+or";

$lang['adminlogempty'] = "aDM1N loG is 3mpTY";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mu\$T SpeciFY 4N @cT1oN +YPe +o r3M0vE";

$lang['alllogentries'] = "aLL L09 En+r1E\$";
$lang['userstatuschanges'] = "u5ER St@Tu\$ ch4N9E\$";
$lang['forumaccesschanges'] = "f0RUM @Cc3\$\$ Chan9ES";
$lang['usermasspostdeletion'] = "u5eR m@S\$ p0\$t Del3+iON";
$lang['ipaddressbanadditions'] = "iP 4ddres5 8@N 4DDi+1onS";
$lang['ipaddressbandeletions'] = "iP 4ddr3s5 B@N d3Le+10Ns";
$lang['threadtitleedits'] = "thR3@D T1TLe 3di+S";
$lang['massthreadmoves'] = "m4S\$ THR3aD mov3s";
$lang['foldercreations'] = "f0LD3r cre@t10n\$";
$lang['folderdeletions'] = "f0lDeR deL3+1ONs";
$lang['profilesectionchanges'] = "proFiL3 S3c+10n Ch4n93s";
$lang['profilesectionadditions'] = "pR0fILe SECti0n @DDITi0NS";
$lang['profilesectiondeletions'] = "pRoPH1le sec+1on dEL3+IOns";
$lang['profileitemchanges'] = "pR0f1le itEM Ch4NG3s";
$lang['profileitemadditions'] = "pRoPH1l3 i+3m Add1+1ons";
$lang['profileitemdeletions'] = "pr0FIle 1t3m DEl3+1onS";
$lang['startpagechanges'] = "sT4rt p4gE ch4NGeS";
$lang['forumstylecreations'] = "f0ruM \$Tyl3 CrEa+10Ns";
$lang['threadmoves'] = "thR3ad moVE\$";
$lang['threadclosures'] = "tHr3@D CLOsures";
$lang['threadopenings'] = "thr34D 0pENIn9\$";
$lang['threadrenames'] = "tHRE4d R3N4ME\$";
$lang['postdeletions'] = "p0st del3t10N\$";
$lang['postedits'] = "p0ST 3dIT5";
$lang['wordfilteredits'] = "w0rd F1l+eR 3dIT\$";
$lang['threadstickycreations'] = "tHr34D \$+icKy Cre4T1ons";
$lang['threadstickydeletions'] = "thre@D sticky dele+1ONS";
$lang['usersessiondeletions'] = "u5ER se\$s10n DeLet10ns";
$lang['forumsettingsedits'] = "forum \$E+t1N9s ED1t\$";
$lang['threadlocks'] = "thre4D l0Cks";
$lang['threadunlocks'] = "tHREad unlOCk\$";
$lang['usermasspostdeletionsinathread'] = "u53r M@ss P0\$+ DEL3+1ons IN @ +Hr34d";
$lang['threaddeletions'] = "thRe4D DeLe+10N\$";
$lang['attachmentdeletions'] = "a++4chm3n+ del3t10NS";
$lang['forumlinkedits'] = "fOrum l1Nk 3ditS";
$lang['postapprovals'] = "p0St 4pproV4lS";
$lang['usergroupcreations'] = "u5eR 9rouP Cr3@T1onS";
$lang['usergroupdeletions'] = "u\$3R 9ROuP DEl3+10ns";
$lang['usergroupuseraddition'] = "u\$3R gr0uP u\$3R 4Dditi0n";
$lang['usergroupuserremoval'] = "us3R gR0up u\$3R r3MOV4L";
$lang['userpasswordchange'] = "us3R pa\$Sword CH4ngE";
$lang['usergroupchanges'] = "u5er 9rOUP Ch4N9es";
$lang['ipaddressbanadditions'] = "ip @Ddre\$s ban 4dDit1oNS";
$lang['ipaddressbandeletions'] = "iP 4Ddr35\$ bAN D3l3+10Ns";
$lang['logonbanadditions'] = "lO9oN b4N 4dDIT1oNs";
$lang['logonbandeletions'] = "lO9oN ban DEle+I0ns";
$lang['nicknamebanadditions'] = "n1CKn4m3 B@n 4dDit1onS";
$lang['nicknamebanadditions'] = "nICknam3 b4n 4dD1TI0n\$";
$lang['e-mailbanadditions'] = "e-M41L 8@N @ddi+ioN5";
$lang['e-mailbandeletions'] = "e-Mail b@n d3letI0nS";
$lang['rssfeedadditions'] = "r5\$ Ph33d 4Dd1tI0ns";
$lang['rssfeedchanges'] = "r5\$ f33d CH4n935";
$lang['threadundeletions'] = "thRe4D unDel3+IOns";
$lang['httprefererbanadditions'] = "hTTp reph3rer 8@N 4DDITi0N5";
$lang['httprefererbandeletions'] = "h++p repher3r 84n dEl3+10NS";
$lang['rssfeeddeletions'] = "r5S feeD DEl3t1ONs";
$lang['banchanges'] = "b4N ch4Nge\$";
$lang['threadsplits'] = "thrEAd splits";
$lang['threadmerges'] = "thread m3RGE\$";
$lang['forumlinkadditions'] = "f0RUm LInk 4dDiTI0NS";
$lang['forumlinkdeletions'] = "foRUm Link D3LeT1onS";
$lang['forumlinktopcaptionchanges'] = "f0RUM l1nk t0P Capti0n ch4n9E\$";
$lang['userdeletions'] = "u5Er Del3+1ons";
$lang['userdatadeletions'] = "useR d4T@ D3l3+10N5";
$lang['usergroupchanges'] = "u5er GR0up Ch@ng3\$";
$lang['ipaddressbancheckresults'] = "ip @DDresS b@N CheCk r3\$ul+s";
$lang['logonbancheckresults'] = "l09on B@n checK r3SultS";
$lang['nicknamebancheckresults'] = "niCKn4M3 84n CHecK r3\$Ul+S";
$lang['emailbancheckresults'] = "em41L b4N cHeck RE\$uLTs";
$lang['httprefererbancheckresults'] = "h+tP r3ph3r3r B@n chEck R3\$Ul+s";

$lang['removeentriesrelatingtoaction'] = "r3M0vE 3n+R1es REl@tin9 +0 4CT1on";
$lang['removeentriesolderthandays'] = "reMOv3 3ntR1es OLD3R TH@n (d@YS)";

$lang['successfullyprunedadminlog'] = "sUCC3S\$FulLy prun3d 4dm1n LOg";
$lang['failedtopruneadminlog'] = "f@iled tO pRUNe @dm1n l09";

$lang['successfullyprunedvisitorlog'] = "sUccE\$\$FuLLY prUN3D vI5it0r lOG";
$lang['failedtoprunevisitorlog'] = "f4il3D tO prune v1si+Or l0g";

$lang['prunelog'] = "pruN3 L0G";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "nO 3x1sTIN9 pH0RUm\$ FOUnd. T0 Cre4te @ n3W ph0RUM CLick teh '4dd NeW' bu+ToN b3l0W.";
$lang['webtaginvalidchars'] = "w3B+4G C@n 0nly c0nT41N uPPErC@se @-Z, 0-9 @Nd unDeR\$COrE Ch4R4cT3RS";
$lang['webtagmaxlength'] = "w3b+4g mUS+ n0 loN9er 32 cH4R4c+er\$ in lENGth";
$lang['invalidforumidorforumnotfound'] = "inv@L1D fORum FId OR ph0RUm NO+ FOund";
$lang['successfullyupdatedforum'] = "succe\$sphullY uPdat3d FORum";
$lang['failedtoupdateforum'] = "f4iLED TO UpD4Te fORuM: '%s'";
$lang['successfullycreatednewforum'] = "sUCCeSSPhully cRea+eD n3w fORuM";
$lang['selectedwebtagisalreadyinuse'] = "tHe SEl3C+3d w3b+4g 1\$ 4lr3Ady iN usE. Ple4\$e Cho0S3 @N0+her.";
$lang['selecteddatabasecontainsconflictingtables'] = "tHe sEL3C+3D d4T@8@s3 con+@1n\$ conflict1N9 T48le\$. cONPhL1C+1ng T@8LE n4MES 4rE:";
$lang['forumdeleteconfirmation'] = "aR3 j00 5uR3 J00 W@n+ +0 del3+e @ll 0PH +h3 \$3LEc+ED pH0Rum\$?";
$lang['forumdeletewarning'] = "pL34se no+3 +h4t j00 c4NN0+ reCoV3r Del3+3d PH0rUm\$. ONCE D3l3+Ed @ PH0RUM 4Nd 4ll of +Eh @S\$0cI4ted D4+4 1s P3rm4Nen+LY Rem0Ved phrom +he d4+A845E. if J00 d0 n0+ W1\$h +0 DelEt3 +h3 \$3leC+3D FOrUmS ple4se cl1ck c@NC3l.";
$lang['successfullyremovedselectedforums'] = "suCC3\$\$fuLLy d3l3+eD 5el3C+3D PHoRum\$";
$lang['failedtodeleteforum'] = "f41l3d t0 d3LEt3D forum: '%s'";
$lang['addforum'] = "add Ph0rUM";
$lang['editforum'] = "ed1t F0rum";
$lang['visitforum'] = "viS1T PH0Rum: %s";
$lang['accesslevel'] = "aCceSS level";
$lang['forumleader'] = "fORum le4Der";
$lang['usedatabase'] = "use D4T48@s3";
$lang['unknownmessagecount'] = "unkn0WN";
$lang['forumwebtag'] = "forum Web+AG";
$lang['defaultforum'] = "d3PH4UL+ pHOruM";
$lang['forumdatabasewarning'] = "pL3@53 enSUR3 J00 S3lEC+ the cORreCT d4T484S3 wH3N cr3@TIn9 4 NEw pHOrum. 0nc3 crE4+ed 4 n3w PH0rum c4nn0+ B3 mOveD 8etW33n 4VA1L@8lE d4+48@se\$.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gL0BAL User perm1\$\$1Ons";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mUS+ \$uppLY @ phoRUm w38T49";
$lang['mustsupplyforumname'] = "j00 mU\$+ SUPPLy A fOrUM N4ME";
$lang['mustsupplyforumemail'] = "j00 MU\$t 5upplY 4 PHORuM 3mail 4DdrEs\$";
$lang['mustchoosedefaultstyle'] = "j00 mus+ choO\$E A deF4ul+ pHorUm s+yl3";
$lang['mustchoosedefaultemoticons'] = "j00 MU5+ chOo\$E d3PH4ul+ PH0RuM EMOT1c0nS";
$lang['mustsupplyforumaccesslevel'] = "j00 MU\$t 5UPPLY 4 F0rum @cC3S5 LEVEL";
$lang['mustsupplyforumdatabasename'] = "j00 mUST SuPPly a fOrum daT@84s3 NAM3";
$lang['unknownemoticonsname'] = "uNkN0Wn 3M0T1CoNs n@me";
$lang['mustchoosedefaultlang'] = "j00 MUS+ cho0se 4 deph4ult F0ruM L4N9UAg3";
$lang['activesessiongreaterthansession'] = "ac+1Ve sES\$ION Time0UT c@nno+ B3 gre4T3r TH@N \$E\$s10n +IM30UT";
$lang['attachmentdirnotwritable'] = "a++4CHm3nt d1REcTory @nd SY\$+EM T3mpOR4ry dir3C+0rY / PhP.1ni 'uplo4D_+mp_dir' Mu5T 8e wR1t@8le 8y the wEb 5erV3R / pHp pROCEs\$!";
$lang['attachmentdirblank'] = "j00 MUST \$uPPLy A d1RECT0rY +o S4v3 a+t@Chm3Nts in";
$lang['mainsettings'] = "m@1n 5EtTIn9\$";
$lang['forumname'] = "foRuM N4me";
$lang['forumemail'] = "fOrUm 3M@1l";
$lang['forumnoreplyemail'] = "nO-reply 3M4IL";
$lang['forumdesc'] = "f0Rum de\$Cr1p+ion";
$lang['forumrooturi'] = "f0ruM RO0t Uri";
$lang['forumkeywords'] = "f0RUm k3YWords";
$lang['forumcontentrating'] = "f0rUM C0n+eNT r@tin9";
$lang['contentdeliverynetwork'] = "coN+3n+ D3L1VeRY";
$lang['contentdeliverynetworkpaths'] = "c0NteNT dElIV3ry n3+WOrk P4+H\$";
$lang['defaultstyle'] = "deph@ul+ S+ylE";
$lang['defaultemoticons'] = "dEphaulT 3MO+1c0n5";
$lang['defaultlanguage'] = "dEf4ul+ L4n9uA93";
$lang['forumaccesssettings'] = "foRUM Acc3\$S 5e+TIN9S";
$lang['forumaccessstatus'] = "f0rum @CCe5s \$t@+U5";
$lang['changepermissions'] = "cHaN9E Perm1S\$10n\$";
$lang['changepassword'] = "cH@n93 P@\$SWOrD";
$lang['passwordprotected'] = "pas5w0rd pR0tec+3D";
$lang['passwordprotectwarning'] = "j00 H4v3 n0+ sE+ a phOruM P4SswOrd. 1F j00 Do nOT \$et 4 PaSSW0Rd +Eh P4SSW0rd pr0+3ctI0N phUNc+10N4l1TY W1LL 83 4utOM4tic4lly D1s48LEd!";
$lang['postoptions'] = "p0S+ opTI0nS";
$lang['allowpostoptions'] = "alL0W po\$T 3DiTIng";
$lang['postedittimeout'] = "p0St edIT +im3out";
$lang['posteditgraceperiod'] = "pOS+ eDit gr4Ce perI0d";
$lang['wikiintegration'] = "wIk1wik1 1N+E9r@t10N";
$lang['enablewikiintegration'] = "eN4ble W1K1wiKI 1n+E9r4tI0n";
$lang['enablewikiquicklinks'] = "eN@8le w1KIWiK1 QU1CK L1Nk\$";
$lang['wikiintegrationuri'] = "w1K1WIki LOc4T1On";
$lang['maximumpostlength'] = "m4X1MUM pos+ l3n9th";
$lang['postfrequency'] = "poS+ PHrequ3ncy";
$lang['enablelinkssection'] = "en4BL3 L1NKS \$Ec+10N";
$lang['allowcreationofpolls'] = "all0W CR34T1ON Of polls";
$lang['allowguestvotesinpolls'] = "aLl0w GU3S+s tO v0t3 IN pOLls";
$lang['unreadmessagescutoff'] = "uNre4D meSS4G3\$ cut-0FF";
$lang['disableunreadmessages'] = "dIS48Le UNR3ad MEss493\$";
$lang['thirtynumberdays'] = "30 d@Y5";
$lang['sixtynumberdays'] = "60 D@y\$";
$lang['ninetynumberdays'] = "90 D4y5";
$lang['hundredeightynumberdays'] = "180 d4ys";
$lang['onenumberyear'] = "1 ye4r";
$lang['unreadcutoffchangewarning'] = "dep3nd1NG oN \$eRVer PErFOrm@Nc3 AND +H3 num83r 0F +hr3@ds Y0Ur pH0rum\$ CON+@1N, cH4N9InG teh unR3@D cUT-0phF MAy take sEV3Ral minu+E\$ t0 c0Mpl3T3. F0r +HIs RE4S0N it Is RecommendEd tHA+ J00 4voID Ch4ngin9 +hiS \$E+T1N9 wh1l3 Y0ur F0ruMS ar3 8usy.";
$lang['unreadcutoffincreasewarning'] = "iNcR3@s1Ng the UNRe@d Cu+-0PHf w1ll m@Ke ThR3@ds M4RK3D 45 ModifI3d S1nc3 @nd thRe4DS 0LD3r th4n t3h pr3v10u\$ cUT-0phf 4pp3ar @\$ UNr3@d +0 4ll u\$Er\$";
$lang['confirmunreadcutoff'] = "arE J00 \$UrE J00 waNT +0 ch4n9e +3h Unr3@d cu+-0fph?";
$lang['otherchangeswillstillbeapplied'] = "cL1ckIN9 'No' Will 0NLY cancEl TH3 uNRE@d Cut-0pHF CH4n9E\$. 0tH3r cH4N9ES yOu'V3 mAD3 w1ll s+1LL b3 S4V3D.";
$lang['searchoptions'] = "s34rCH OPtI0NS";
$lang['searchfrequency'] = "s34rCH phrequ3nCy";
$lang['sessions'] = "sE\$s1on5";
$lang['sessioncutoffseconds'] = "sEs5i0n cu+ ofF (\$EcONDs)";
$lang['activesessioncutoffseconds'] = "aC+Iv3 se5s1on cut 0fph (s3coNd\$)";
$lang['stats'] = "s+@T\$";
$lang['hide_stats'] = "hID3 S+4+5";
$lang['show_stats'] = "sHow 5+4T\$";
$lang['enablestatsdisplay'] = "en@8le ST@t\$ d1SPL4y";
$lang['personalmessages'] = "p3r\$on4l mes\$4Ge\$";
$lang['enablepersonalmessages'] = "eN@8le PErS0N4l M3ssAg3\$";
$lang['pmusermessages'] = "pM M35S493\$ p3r user";
$lang['allowpmstohaveattachments'] = "alL0w p3r5on4l m3\$S@9E\$ +0 haV3 4++AchmentS";
$lang['autopruneuserspmfoldersevery'] = "aU+O PRune U\$eR'\$ PM foLdERS 3veRy";
$lang['userandguestoptions'] = "u\$3R 4Nd GU35+ Op+1Ons";
$lang['enableguestaccount'] = "en@BLe 9u35t 4CC0un+";
$lang['listguestsinvisitorlog'] = "l1S+ 9U3s+S 1N vi51tor l09";
$lang['allowguestaccess'] = "all0w GU3S+ 4ccE\$s";
$lang['userandguestaccesssettings'] = "u\$ER aNd 9u3\$t @cCESS S3+Tin9s";
$lang['allowuserstochangeusername'] = "aLL0W User\$ +O cH4N93 uS3rN4m3";
$lang['requireuserapproval'] = "r3QUiR3 Us3r @ppR0v@L bY aDm1n";
$lang['requireforumrulesagreement'] = "rEQUIre User +o 4GR33 T0 f0rum RUlEs";
$lang['sendnewuseremailnotifications'] = "s3ND nOT1pHiC4t1ON +0 gl0B@l PH0RUm 0wNEr";
$lang['enableattachments'] = "eN@8l3 @t+4CHMeNT\$";
$lang['enableattachmentthumbnails'] = "enABlE 4+Tachm3N+ 1m@93 THUMbN4Il\$";
$lang['attachmentdir'] = "a+T@chmeN+ dIR";
$lang['userattachmentspace'] = "aTt@ChM3nt SP4Ce PeR usER";
$lang['userattachmentspaceperpost'] = "aT+@chm3NT 5P4Ce p3r P0S+";
$lang['allowembeddingofattachments'] = "aLLOW 3m83dD1Ng 0PH 4t+AChmEN+s";
$lang['usealtattachmentmethod'] = "u\$3 4lTerna+iv3 @++4ChM3N+ meth0D";
$lang['allowgueststoaccessattachments'] = "aLlow 9u3\$+s TO 4cCEs\$ 4+T@Chm3ntS";
$lang['allowedattachmentmimetypes'] = "aLLOw3d 4++4Chm3N+ Mim3-TYp35";
$lang['forumsettingsupdated'] = "forum \$Et+1NGs \$UCCes5fuLLy upd4t3d";
$lang['forumstatusmessages'] = "fOrUm ST@Tu\$ me\$s4ges";
$lang['forumclosedmessage'] = "foRUM cl0s3d Me\$s@ge";
$lang['forumrestrictedmessage'] = "f0RUM r35TRICt3d MESs@ge";
$lang['forumpasswordprotectedmessage'] = "f0rUM P@ssW0RD PR0+ec+ed mes\$4G3";
$lang['googleanalytics'] = "gOogL3 4N4lY+ics";
$lang['enablegoogleanalytics'] = "en@8le GO09l3 @n@Ly+1CS";
$lang['allowforumgoogleanalytics'] = "aLloW g0ogLe An4ly+IC5 oN 3ACh PhoRuM";
$lang['googleanalyticsaccountid'] = "g00gL3 4n4Lyt1C5 4cC0unt iD";

$lang['googleadsense'] = "gOo9l3 @d\$eNSE";
$lang['adsensepublisherid'] = "aDsen5e publISH3r id";
$lang['adsensemediumadid'] = "m3d1um \$1z3D (468x60) AD sL0+ 1D";
$lang['adsensesmalladid'] = "sM4LL sIZeD (234x60) AD \$Lo+ 1d";
$lang['adsenseallusers'] = "aLL u\$3rS";
$lang['adsenseguestsonly'] = "gUEST5 oNLy";
$lang['adsensenoone'] = "nO-onE (dis48leD)";
$lang['adsensedisplayadsforusers'] = "di\$pL@y AdSen\$E 4DS ph0r";
$lang['adsensedisplayadsonpages'] = "d15pl@Y 4DseNsE 4ds 0n";
$lang['adsenseallpages'] = "t0P of Every p4ge";
$lang['adsensetopofmessages'] = "t0P Oph ME\$S4g3\$";
$lang['adsenseafterfirstmessage'] = "aFt3r 1\$T Me5S49E";
$lang['adsenseafterthirdmessage'] = "aFter 3rd me5s4ge";
$lang['adsenseafterfifthmessage'] = "aPHt3r 5+h mE\$s4Ge";
$lang['adsenseaftertenthmessage'] = "aF+3r 10+h M3sS4ge";
$lang['adsenseafterrandommessage'] = "aFTeR 4 r@nd0m M3\$\$@9e";
$lang['registertoremoveadverts'] = "r39I5ter +o R3moVE thes3 4dv3r+S.";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0s+ Ed1+ +1M3Out</b> I\$ +HE +1M3 iN m1nut3S 4Phter PostINg +h@T 4 us3R C@n 3dit +HE1r P0St. iph 5e+ +0 0 +HER3 i5 N0 L1M1t.";
$lang['forum_settings_help_11'] = "<b>maXimUm pOST len9th</b> 1\$ +hE m4ximum Num8Er OF cH4R4C+eRS th4+ W1lL bE D1spl@Y3d iN 4 pO5T. 1f @ P05t is l0NGeR TH@n THe num8Er 0PH CH4RActerS d3FIneD Her3 1T wiLl 83 Cu+ Sh0RT @Nd 4 l1NK addEd +O +3h 80tT0M to all0w US3rs T0 re@d teh wHol3 po\$+ oN 4 \$eP4r4t3 P493.";
$lang['forum_settings_help_12'] = "iPh j00 D0n'+ w4nt y0ur U53rS tO Be @bL3 TO Cr3@T3 POll5 j00 c4n d1S48Le +3H ab0v3 0pTI0n.";
$lang['forum_settings_help_13'] = "tH3 l1nKS \$eC+10n oPH BE3HIv3 PR0V1dES @ pl@ce PH0R y0Ur us3R\$ +0 M41n+@1N @ l1st 0F s1t3s ThEY fR3quEntlY v1s1T tH4T OTh3R us3rs m4Y f1nD U53phul. lINk\$ c4N b3 DIViDed 1n+0 c4+e90r1es 8y f0lder 4nd 4lLOw fOR c0MMEn+s 4nd r@t1n9\$ T0 8e gIVen. In 0rder to MODer4Te +Eh L1nkS sec+1ON @ uS3R MU\$t 83 R@NTed gl08aL M0DeR@+0r \$+4tuS.";
$lang['forum_settings_help_15'] = "<b>s3\$sI0n cu+ Off</b> I\$ +h3 M4x1mum +1M3 83ph0Re @ u\$Er'S \$essi0n is d33M3D dEad 4nd +h3y 4r3 l0GG3d 0UT. 8Y d3PH4ULT th1S iS 24 HOUr5 (86400 s3cONDs).";
$lang['forum_settings_help_16'] = "<b>aC+1ve \$e\$s1oN CUt OFf</b> 1s +eh M4XImum +im3 8EPH0RE @ us3r'S \$35S1on 1\$ deEm3d 1naC+iv3 @+ WH1ch P0iN+ +heY EN+eR @n 1DL3 5TAte. 1n +H1S ST4T3 +eh user r3m41Ns loG93D 1n, 8ut THeY 4r3 r3m0veD PHroM +eh @cT1VE USErs LIst In +eh \$T@T\$ disPLay. ONce They 83C0ME 4CtiVe 494iN +hEY WIll B3 r3-4dd3D +0 tHE L1st. by DepH@UL+ +hIs S3+t1N9 1S seT T0 15 M1NUTes (900 \$eC0nds).";
$lang['forum_settings_help_17'] = "en@8l1N9 +HIs 0pt10n 4lLOwS 83EH1vE TO 1ncluD3 @ 5+4tS d1Spl@Y @t TH3 80+tOM oph ThE ME\$s4GEs P4n3 s1MiL4R +0 +3h On3 u\$ED BY m@ny f0Rum 50PH+w4r3 T1tl35. 0nCe en4bL3d T3H d1spl4Y Oph +h3 \$tA+s p4ge c@n 83 tO9glEd 1ND1Vidu4Lly 8y e@Ch u5Er. If thEY d0n'T w@N+ +o 533 1t +HEy C4n H1d3 1t fRom View.";
$lang['forum_settings_help_18'] = "pERS0n4l m3s54Ge\$ 4r3 inV@lu4BlE 4s @ w@y 0ph +aK1ng mORe PR1Va+3 m4T+erS 0Ut 0ph view 0ph ThE Oth3r m3M8er5. HOwEv3r 1F J00 D0N'+ WAnt y0UR user5 +0 8e @bl3 T0 sENd 3Ach o+H3R P3rs0nal mE\$s@ge\$ j00 C@n D1S@8le ThiS 0p+1oN.";
$lang['forum_settings_help_19'] = "peR\$on4l ME\$S49E\$ C4N 4Ls0 Cont4in 4++4Chm3n+S wh1Ch C@N 8e usEPhul ph0r exCh4n91NG phile\$ BETw33n u\$Ers.";
$lang['forum_settings_help_20'] = "<b>n0tE:</b> +EH sp4c3 alloC@Ti0N phor pM 4++@chmeNT5 iS +4k3N frOm 3acH Users' M4IN 4+t@cHMeN+ 4ll0C4+1on 4nd 1\$ n0+ 1N 4dd1Ti0N TO.";
$lang['forum_settings_help_21'] = "<b>en4bl3 9u3S+ 4Cc0un+</b> @LL0ws viS1TORS +0 8rowS3 Y0ur ph0ruM aND r3@d p0\$+\$ witHOut RE91s+Er1NG 4 u\$eR 4CC0UN+. 4 U5er 4Cc0unT 1S \$tILL R3quireD iPH tH3y Wish To pO\$t 0R change usER pRePHerENc35.";
$lang['forum_settings_help_22'] = "<b>l1St 9ue\$ts 1n v1sIT0r lOG</b> 4lLoW\$ j00 +0 sp3c1Phy wHe+her OR n0T unRE9i\$Ter3D uS3R\$ AR3 li\$t3d 0N +3H vISi+OR lOg @LOn9s1de re91\$+3r3d u\$Er5.";
$lang['forum_settings_help_23'] = "be3hIv3 4llow\$ 4tt4ChMEnT\$ +0 B3 uPLO4DED To m3sS49e5 WHeN Po5T3D. if j00 h4V3 liM1+ed W3b Sp@Ce j00 M4y wHICh +O d1S@8l3 4++4cHMent\$ bY cle@R1NG +he 8oX @B0VE.";
$lang['forum_settings_help_24'] = "<b>atTacHM3n+ d1r</b> 1S tHE lOCa+1ON b33h1v3 \$Hould st0r3 4t+4chm3nt5 1N. thiS dIr3C+ory Mus+ 3x1\$+ On Y0UR weB \$p@Ce @Nd mu\$T be WritabLe By +3h weB 5Erver / PHP pR0c35s 0+H3Rwi5e uplo4ds wILL F@1l.";
$lang['forum_settings_help_25'] = "<b>at+4CHmEnT 5pac3 Per USER</b> 1\$ The m@x1MUM 4mOUn+ oPH d1sk 5pAC3 4 USER H@\$ pH0r 4tt@ChM3N+s. ONC3 thi5 \$p4Ce iS us3D up +H3 U5eR C4nn0+ upl0ad 4NY m0re 4T+4chm3n+S. BY D3Ph@Ul+ +h1S I\$ 1mB 0f sp@c3.";
$lang['forum_settings_help_26'] = "<b>aLL0w em8eDd1n9 0f ATT@CHm3nT\$ IN MeS\$49e\$ / 5igN@+uR3\$</b> 4LL0ws US3rs +0 3m83D 4t+@chm3nt\$ 1n p0\$+s. 3NABl1N9 +hiS oPt1oN WHile U53ful c4n iNcr34S3 y0uR b@ndw1Dth u54GE DRA5T1cally unDer c3RT@In c0Nfi9uR@T1ON\$ OF pHP. ipH j00 H4V3 liM1Ted 8@ndw1dth 1t i\$ rEC0mmEND3d +h@T j00 DIS48L3 thiS 0ptI0n.";
$lang['forum_settings_help_27'] = "<b>uS3 alt3rN4TIv3 4+tachMen+ M3Th0d</b> Phorce5 8EehiVE to uSE @n 4LtERNa+IVe retr13val M3+H0d PH0R 4+T4cHM3n+S. 1pH j00 Rec3ive 404 3rrOR mes\$4G3s Wh3n +rYIng +O d0wnL0@D 4t+4CHment\$ Fr0m M3\$S@9Es +RY EN@8lin9 +His Opt1ON.";
$lang['forum_settings_help_28'] = "th3S3 \$E+t1n9s @lL0w5 y0ur forum +0 B3 \$p1d3r3D BY \$e4RCh en91N3\$ lik3 9O0Gle, @L+4VI5+4 4Nd y4h00. 1F j00 SWItCh th1\$ 0p+1on Off y0Ur PH0rum W1LL no+ 83 1NcLUd3D 1N +hes3 \$3arch 3ng1n3\$ r3SUlTS.";
$lang['forum_settings_help_29'] = "<b>aLl0w new USer r3g1\$Tr@TiONS</b> 4LL0ws 0R dis@lloW\$ +EH CR3a+10n OF neW UseR 4cc0unts. S3+T1n9 +eh 0p+iON +0 nO cOMPlET3ly dis48l3s The r39I\$tra+1ON ph0RM.";
$lang['forum_settings_help_30'] = "<b>eN4BLE w1k1wiK1 1nteGRa+10n</b> prOV1Des WiKiwORd supPOrt In Y0uR ph0rum p0\$t\$. 4 wIKiword 1S m4de up of tW0 Or m0rE coNC@TeN4+ed WORdS w1+h Upp3rc@sE lEt+3rs (0F+3n r3PH3rred to 4s c@mElca\$E). IF j00 WR1Te @ w0Rd +h1S w4y 1+ W1LL 4uT0M@tIC4lly b3 CHaN9ed 1n+0 4 Hyp3rLink P01n+1nG T0 youR chO5En wIKiWIK1.";
$lang['forum_settings_help_31'] = "<b>eN48LE w1kiwiki QU1ck l1nks</b> EN@BL3\$ T3H uSE 0PH MSG:1.1 4nD useR:lOG0N s+YL3 Ex+end3D w1KILinks Wh1Ch crE4t3 hyp3rl1nk\$ t0 th3 sp3C1fieD mes\$4G3 / US3R prOF1LE 0PH +3H SPeC1fiEd uSEr.";
$lang['forum_settings_help_32'] = "<b>wIK1Wik1 loca+1oN</b> Is uSEd +0 5pec1phy t3H Uri OPh y0Ur wiKIw1k1. wH3N en+eriN9 +hE Ur1 USe <i>%1\$5</i> To 1NdICatE WHErE in +H3 Uri +H3 w1kiwoRD shOUlD @pp3AR, 1.3.: <i>hT+p://3n.Wik1p3dI4.ORg/w1k1/%1\$S</i> W0uld l1nk youR wikiwoRdS +0 %s";
$lang['forum_settings_help_33'] = "<b>fOrUM @cCEsS 5+4+u\$</b> cON+ROlS how Us3rS m4y @cC35s YoUR forUM.";
$lang['forum_settings_help_34'] = "<b>oP3n</b> will @ll0W AlL us3Rs 4ND gu3\$+s @cCess +0 y0ur PH0rum w1th0ut Res+r1CtioN.";
$lang['forum_settings_help_35'] = "<b>cLOS3D</b> PreVEN+\$ 4CCe\$S Ph0r 4LL U\$3rS, Wi+h the 3xcept1on 0ph +3h @dMIn who M@y s+1ll 4cC3\$s +He 4DM1n P4neL.";
$lang['forum_settings_help_36'] = "<b>re\$+rict3d</b> ALL0W\$ to SEt a L1St 0F USerS wHO 4re 4lloweD @Cc35s TO yOuR ph0rUM.";
$lang['forum_settings_help_37'] = "<b>p4S\$worD PR0tec+ed</b> 4llows J00 to se+ A p4s5w0rd +o 91V3 ouT +0 us3r\$ \$o +h3y c4n acC3\$s y0ur F0ruM.";
$lang['forum_settings_help_38'] = "when \$3ttin9 r3\$tr1C+ed 0r P4\$swORd pr0tec+3D mode j00 W1ll n3Ed to S4VE y0ur CH4n9E\$ 83pH0r3 J00 c4N Ch4ng3 TH3 uSeR 4CCe\$s PR1V1LEg35 or p4sswOrD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"FROm k1llINg +eh 5erver.";
$lang['forum_settings_help_40'] = "<b>pOs+ fR3quency</b> 1S +EH m1nIMuM t1m3 @ u5Er Mu\$T w4i+ 83Ph0re th3y c4n po\$+ AG4in. ThiS se++1ng 4lso 4FPh3Cts +H3 cRE4ti0n Of P0llS. s3t to 0 tO d1s48le +H3 Re\$tR1C+1on.";
$lang['forum_settings_help_41'] = "tHe 4b0VE 0P+10n\$ ch@n93 Teh deph@ul+ v@LU3\$ f0R TH3 u\$eR rEgIStr@TI0N pH0rM. wher3 @PPlic48l3 0thEr SE+t1n9\$ w1ll uSE the phoRuM'S own dEFaulT se+T1ngs.";
$lang['forum_settings_help_42'] = "<b>pR3v3nt U\$E 0ph DUpl1c4TE 3m41l 4DdrES\$35</b> PhORCE\$ B3ehIv3 +o ch3ck th3 user 4CC0unt\$ 4941n\$T +eH EM@1l AddRE\$s the u5er 1s r3g1S+er1nG With and pr0mptS them tO uS3 @N0tH3R if IT 1\$ @LR3@dY in uSe.";
$lang['forum_settings_help_43'] = "<b>r3quir3 3m4il confIRM@t1ON</b> Wh3n eN4Bl3d WILL sENd 4N 3m@1L t0 e4CH New USer W1Th 4 L1NK tHA+ c4N 8e used To c0nfIRM th3ir 3m4il 4ddress. un+1L th3y c0NPHIRM TH3ir EM4iL @ddRES\$ +heY w1ll Not b3 @8LE +0 pOsT unL3\$s thEIR u\$3R P3RM1sS10nS @r3 ch4N9Ed M@nuAlly 8Y 4n @DMin.";
$lang['forum_settings_help_44'] = "<b>us3 T3Xt-C4p+ch@</b> PRe53NtS the N3W u\$3r WItH 4 m@N9l3D 1ma93 Which +h3Y mus+ cOpy 4 num8er froM in+o 4 +3x+ F1ELd oN +Eh reG1s+r4ti0n PH0RM. use +his OpT1oN +0 Pr3V3Nt @ut0m@t3d s1gn-Up vi4 SCRipt5.";
$lang['forum_settings_help_47'] = "<b>po\$t EdIT 9r4c3 pErI0D</b> 4ll0w5 J00 T0 dePH1n3 @ peri0d 1n m1nutes wh3r3 Users M@y 3Dit p0s+5 without t3h 'edIt3d 8y' T3XT @pp3ARiNG on +heiR p0s+s. 1f sE+ +0 0 tEH '3D1+3d 8Y' +ExT w1LL @lw@y\$ APPe4R.";
$lang['forum_settings_help_48'] = "<b>uNRe@D m3s5493\$ cUt-Ophf</b> SpeciFI35 h0W LoN9 ME5s4g3s R3m41n UNR34d. +hre@D\$ M0D1ph1Ed n0 la+3R +h4n tH3 P3r10d seLecTed W1ll AutoM4t1c@LLy 4pp3ar 45 read.";
$lang['forum_settings_help_49'] = "cH00\$1NG <b>dis48L3 Unre4d M3\$\$@93S</b> W1LL C0mPLE+ely reM0VE unre4D mes\$4GeS 5UPP0RT @nD R3m0Ve teh R3lEv@N+ opTIon5 Fr0m T3h D1SCU\$s10n +YP3 DroP down 0N +he thR3@d l1\$t.";
$lang['forum_settings_help_50'] = "<b>rEqUir3 uSer 4ppR0V@l 8Y @dm1n</b> @llOW\$ j00 +o re\$+rICt @cC3s\$ by n3w u5er\$ Unt1l th3y h4v3 833N 4Ppr0vEd 8y 4 mod3r@tor 0R @DM1n. wi+h0U+ 4ppr0val 4 us3r c4nNOt @ccesS @ny 4REa oPH +hE 833hiv3 FORuM 1NS+4LL4tion 1ncLUDin9 InDiv1du4l f0RUm\$, PM 1n80x 4nD my PhoRum5 seC+1onS.";
$lang['forum_settings_help_51'] = "u5e <b>cloSEd m3\$S4ge</b>, <b>re\$TrIctEd mes5493</b> aND <b>p4\$\$WoRD pr0+Ect3D me\$s4Ge</b> To cUS+0M153 +3h Me\$S4g3 diSPl@y3d when uSErs Acc3\$s youR foRuM in +H3 V4R10us S+4+E5.";
$lang['forum_settings_help_52'] = "j00 c4n u\$e h+Ml In YOur m3s\$4g3S. HYp3rl1nks AnD 3m4iL 4dDre\$sEs WilL 4LSO 83 @u+0m4t1C4LLY COnv3RTeD TO l1Nks. +0 uSE tEh DEf@UL+ be3HIV3 FOrum MEss4ges cLear +he Ph1eld\$.";
$lang['forum_settings_help_53'] = "<b>all0W user\$ +o ch4n93 us3rnam3</b> P3RMi+s 4lreAdY r39Is+3rEd US3Rs +O cH4NG3 thE1r u\$eRN4me. wh3N eN48lEd J00 C4n +r4Ck +eh ch4n9E\$ 4 u\$3r m4K3s TO +he1R useRN4me V14 teh 4dm1N User to0ls.";
$lang['forum_settings_help_54'] = "uSe <b>f0rum rules</b> to EnTeR 4n 4ccEP+48le us3 P0L1cy THA+ 3ach u\$Er MU\$T AgR33 +o b3ph0Re r3g1\$+eriN9 0n YouR f0rUM.";
$lang['forum_settings_help_55'] = "j00 C4n u\$e H+ml 1n YOur Ph0RuM rUl3s. HYP3rLInk\$ 4Nd em@il 4Ddre\$sES will 4l50 83 @Ut0M4+1c4lly C0nvER+ed +0 l1nkS. to uSE tH3 dePhaUL+ b3eh1ve Ph0rum @uP Cl3@r +h3 f1Eld.";
$lang['forum_settings_help_56'] = "u53 <b>nO-R3Ply EM@1l</b> to SP3ciPHY @N 3m4il 4dDr3\$s +h4t dO3\$ n0+ 3xis+ OR w1LL noT b3 MONi+0r3D for r3plIE\$. +hiS 3maIL AdDr3s5 W1LL b3 us3D 1N THe he4Der\$ phoR 4ll EM4IL\$ \$3NT pHRoM Y0UR f0RUM 1NCludin9 But N0+ lIM1+3D to PO\$+ 4nD pm N0T1F1Ca+10ns, uS3R em4iL\$ ANd P4\$\$wORd REMind3rS.";
$lang['forum_settings_help_57'] = "i+ Is rec0mm3ndEd +h4t j00 uSe 4N Em4IL @Ddr35S +H4T do3s N0+ 3xI\$+ +0 h3lP cUt DoWN on \$P4m +h4+ M4y be D1REC+3D @t YouR main PH0rum em41l 4DDresS";
$lang['forum_settings_help_58'] = "in @DDitI0N to Simple \$pIdERinG, BeEHIv3 c4n al\$o GeNer4+3 @ 51t3MAP f0r teh fORUm +o M@kE IT 3@5ier for S34RCh En91N3\$ +0 PHIND @nd IND3x T3h mesS493\$ PoST3d 8y yoUR uSeR5.";
$lang['forum_settings_help_59'] = "s1+3m4ps @Re 4U+Om4Tic@lly S@ved TO t3H S1t3m4p5 \$UB-dir3C+0ry of Y0UR 8eeh1v3 ForuM inS+4ll4t10N. if thiS d1rec+ORY DO35n't eX1s+ j00 mus+ cre4t3 1+ 4nD 3nSUr3 +h4+ 1+ iS wR1T@8l3 8Y TH3 serv3r / phP proc3\$S. +o 4LLOw s3ArcH 3n91N3\$ t0 f1nd your \$1teM4p j00 MU\$T @dD t3h Url T0 yoUR RobOTS.tXT.";
$lang['forum_settings_help_60'] = "d3pENdiN9 0n \$3rV3R p3RPHoRM4NCe 4nd +h3 numB3R 0f phORum\$ 4nd tHRE4Ds Y0UR b3EhiVE 1Ns+ALL4T1on cONt41ns, 9en3R@+1n9 a S1teM4p m@Y +4KE S3VeR@L mINut3s +0 c0mpl3+e. iF PerPH0RMANCe 0f YOur \$3rv3r 1\$ ADvErs3ly 4fphec+eD i+ i5 REC0mmend j00 Di\$@ble 9eneR4tI0N 0F +3h 51T3m4p.";
$lang['forum_settings_help_61'] = "<b>s3nd em@IL nOT1F1c4ti0n +0 GloB@L @dmiN</b> WH3N 3nabL3d wILl \$End 4n EM@1L +o +H3 9l0B@L f0Rum 0wN3R\$ wh3n 4 N3W useR @cCount is CR3@t3D.";
$lang['forum_settings_help_61'] = "enT3R YOur <b>gO09l3 4nALytics 4cCount ID</b> HEr3 +o 3n48LE gO09l3 4n4ly+iC +R4ck1n9 0ph yoUR F0ruM. gooGl3 @N@ly+1cS w1LL +R4cK v1sITor\$ +0 y0ur \$1+3 4Nd reCord h0w l0ng th3y s+4Y @Nd Which P49eS +H3y VIs1t. 8y VISit1n9 +3h g00gLe @n@lYT1Cs SI+3 j00 caN s33 @N oV3rv1Ew of HOW y0ur F0ruM 1s Used.";
$lang['forum_settings_help_62'] = "If you do not have a Google Analytics Account you will need to sign up for one by clicking <a href=\"https://www.google.com/analytics/\" target=\"_blank\">here</4 >.";
$lang['forum_settings_help_63'] = "If you do not have a Google AdSense Account you will need to sign up for one by clicking <a href=\"https://www.google.com/adsense/\" target=\"_blank\">here</@ >.";
$lang['forum_settings_help_64'] = "iF j00 wi\$H +o En@8l3 0r d1548le Go09L3 AdSEn5e @Ds oN 4 P@RtIcul4r phORuM j00 C4N do \$0 8Y vi51TIng Tha+ f0Rum'S f0rum SEt+1NGS pag3.";
$lang['forum_settings_help_65'] = "tO CH4n93 go09L3 @d\$En\$E 4ccount D3TAILs aNd 0TH3r \$eT+in9s pl34se \$E3 Gl084L f0rum \$EttIN9\$";
$lang['forum_settings_help_66'] = "youR be3h1ve forum \$uPP0rt5 2 diPHPh3R3NT \$1ZE\$ oF <b>g0o9l3 @d\$3NSE</b> 4dv3r+5. 3nter the sLOT iDs 0ph Th3 relEV@n+ \$1Zed @d5 1nto +he B0x3\$ aB0ve 4nD 833HIv3 W1LL AUTom@T1c4Lly cho0\$e +3h c0rreC+ Ad For e@ch p4ge.";
$lang['forum_settings_help_67'] = "seLecT +eH <b>m@1l pHuNc+1On</b> sUitaBL3 For Your S3RV3r. 8y def4ULt y0ur b3Eh1ve forUm w1ll us3 PHp's buIlt-1n M4IL func+1oN. if +HiS d03\$N't w0rk 0r J00 pref3r +0 u\$e @notH3r Me+hod +O s3nd EM@1Ls Phrom YOUr \$ERV3R j00 c@N Sel3CT i+ HER3.";
$lang['forum_settings_help_68'] = "<b>iMPORT@n+:</b> ipH j00 AR3 un5Ur3 wh@t Set+1n9\$ tO US3 for SenDIN9 3M41L pl3@\$E conSUl+ Y0UR H0StIN9 PRoV1D3R'\$ docuM3NT4t1on.";
$lang['forum_settings_help_69'] = "y0UR <b>foRum ro0+ uRI</b> 1s +eh @ddRes\$ +0 your ph0rUM, eXCluD1n9 T3h fiLE p4th 4ND qU3ry 5tR1n9. 3xaMPl3: <i>h++p://wWW.B3Eh1v3Forum.N3+/Ph0rum</i>";
$lang['forum_settings_help_70'] = "<b>imPoRt4N+:</b> Only en+eR 4 <b>fOrUm ROOT ur1</b> If 83EhiV3 PH41Ls +O 4u+0M4t1C4llY dE+eC+ your ph0rUM's Uri OR if It d3+3c+s +3H wr0nG v4LUE. 3nT3RIN9 @N incoRRec+ v4lu3 c0ULD m4KE soME @r3a\$ of Y0uR B3eh1ve fORUM iN5t@LL@+IoN 1n4cc3\$\$I8l3.";
$lang['forum_settings_help_71'] = "a <b>coNTent DeL1V3ry Netw0rk</b> Or cDn c4n B3 US3d tO h3lp 5p3ed up p@g3 L0@d of YOUr forum by OPhF-lo@D1n9 50me 0PH p493 CoN+3nt \$uCH @\$ 1M4GEs, Css @Nd j4V@SCripT +o 0Th3r seRVeRS.";
$lang['forum_settings_help_72'] = "j00 \$houlD 3NTer 4ny CDn P@tHS 1N tEH t3Xt b0X 480VE, 0N3 PEr l1n3. y0ur 833HiV3 Phorum WiLl 4u+Om4T1C4Lly PrEPH1x 3very st@T1C CON+3Nt ReQue\$t W1TH 34ch OPh +HE Cdn P@+HS in turn.";
$lang['forum_settings_help_73'] = "plE4se no+E: y0ur cdN p4+HS \$houLd 8E +0 TEh rO0T 0ph tHE b3EHiv3 forUM CoN+3nt. for ex@MPlE, Iph j00 enter <i>cdn01.MY833h1vepH0rum.net</i>, REQuE\$tS foR +EH u5er'S cs\$ \$tyl3s wIll 83 m4DE TO <i>cdn01.my833H1vepHORUm.N3+/\$Tyl3s/[u\$3R_S+yl3]/s+YLE.cSS</i>";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1d nO+ SP3cifi3D.";
$lang['upload'] = "uPL0@D";
$lang['waitdotdotdot'] = "w41+&hellip;";
$lang['successfullyuploaded'] = "sUCce5SPhully upL0@dED: %s";
$lang['failedtoupload'] = "f4Il3d to upl04D: %s. CHeck pHR33 4+t@Chm3nt \$P4c3!";
$lang['mimetypenotallowed'] = "f4il3d t0 uPLOAd: %s. FiLe +Ype i\$ N0+ 4LL0w3d!";
$lang['complete'] = "c0mPL3+3";
$lang['uploadattachment'] = "upL04d a Ph1Le for 4T+@chM3n+ To t3H mess@9E";
$lang['enterfilenamestoupload'] = "enT3R filen@m3(\$) t0 upl0@d";
$lang['uploadanotherattachment'] = "uPlo4d @noth3r 4t+@CHMeNT";
$lang['attachmentsforthismessage'] = "aT+4cHMents PHor th1\$ M3\$s4g3";
$lang['otherattachmentsincludingpm'] = "o+her 4t+4cHMEn+S (incLudin9 pM m3\$S4ges 4nd 0+Her foRUmS)";
$lang['totalsize'] = "t0+@L s1Ze";
$lang['freespace'] = "fReE 5paC3";
$lang['attachmentproblem'] = "thEr3 w4\$ 4 pRO8l3M downl0@d1ng +h1\$ 4T+4Chm3NT. ple@se +rY 4g4in l4tEr.";
$lang['attachmentshavebeendisabled'] = "aTt@ChmENT\$ H@vE 833N d1s4blEd By TH3 pHoruM 0Wner.";
$lang['deleteattachments'] = "dEl3t3 4+T4Chm3NT\$";
$lang['deleteattachmentsconfirm'] = "aR3 J00 \$uRE j00 W4n+ to D3L3+E teH S3leC+3d AT+4chmen+s?";
$lang['deletethumbnailsconfirm'] = "aRe J00 \$Ur3 J00 w@n+ +0 dElE+e +eH 5el3C+ED 4t+4ChM3nt\$ THumBN@1L\$?";
$lang['failedtodeleteallselectedattachments'] = "f41led to d3L3+e @Ll OPh +H3 sel3C+ed 4+t@Chm3N+S";
$lang['failedtodeleteallselectedattachmentthumbnails'] = "f@ILEd +0 Del3+3 4ll 0f THe 5el3c+ed 4+TAcHmen+ +HUmBN4ILS";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@\$swORd cH4n93d";
$lang['passedchangedexp'] = "youR paS\$w0RD h@S B3en ch@nged.";
$lang['updatefailed'] = "upd4te pH4iL3D";
$lang['passwdsdonotmatch'] = "paSsw0RdS dO NOt M4+cH.";
$lang['newandoldpasswdarethesame'] = "new 4ND 0lD Pas5worD\$ 4r3 +3H 54ME.";
$lang['requiredinformationnotfound'] = "rEQUirEd INforM4ti0n nO+ ph0unD";
$lang['forgotpasswd'] = "for90+ p@5\$Word";
$lang['resetpassword'] = "rE5E+ p4\$Sw0Rd";
$lang['resetpasswordto'] = "r3SeT p4sSWORD +o";
$lang['invaliduseraccount'] = "iNV@L1d US3R 4Ccount Sp3C1phied. cheCk eM4il Phor c0rreCt lINk";
$lang['invaliduserkeyprovided'] = "inV4lID useR kEy pROvideD. CheCk em@1l PH0r cORR3ct l1nK";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "nO M3\$S4g3 5P3C1phieD f0R d3L3+1oN";
$lang['deletemessage'] = "dele+e m3sS4Ge";
$lang['successfullydeletedpost'] = "sUccessPHuLLY DELE+3D poS+ %s";
$lang['errordelpost'] = "eRR0R del3+1Ng p0\$t";
$lang['cannotdeletepostsinthisfolder'] = "j00 c4nno+ d3l3t3 p0\$T5 1N THis PhoLd3r";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "no M3\$S49E speCIF1eD f0r 3Di+In9";
$lang['cannoteditpollsinlightmode'] = "c4Nn0+ eDit P0Ll5 1n l1gHT M0d3";
$lang['editedbyuser'] = "eD1+3d: %s 8Y %s";
$lang['successfullyeditedpost'] = "sUccEssPHully 3D1Ted Po\$T %s";
$lang['errorupdatingpost'] = "erRor UPd@+ING POSt";
$lang['editmessage'] = "eD1+ m3\$\$@9E %s";
$lang['editpollwarning'] = "<b>n0+E</b>: 3D1+1ng cer+4iN @5pEc+s of 4 P0lL w1Ll VoiD @Ll +Eh curr3nt VO+es @Nd 4Ll0w p30ple +0 VOTE 4g4iN.";
$lang['hardedit'] = "haRD 3D1T 0pt1oNS (vote\$ w1ll B3 rE\$eT):";
$lang['softedit'] = "s0f+ edi+ Op+10nS (vote\$ wiLL 83 re+@ineD):";
$lang['changewhenpollcloses'] = "cHaN9E wh3n +HE poll cLO\$E\$?";
$lang['nochange'] = "no CH4N9e";
$lang['emailresult'] = "eM@1l re\$Ul+";
$lang['msgsent'] = "meSS49e \$EnT";
$lang['msgsentsuccessfully'] = "m3ss493 S3n+ \$UCC3\$\$Fully.";
$lang['mailsystemfailure'] = "m4IL sYS+Em pHAilur3. M3\$s4ge no+ S3nt.";
$lang['nopermissiontoedit'] = "j00 4R3 NOT p3rmi+T3D tO 3d1+ +h1s m3ss4ge.";
$lang['cannoteditpostsinthisfolder'] = "j00 c@NN0T EDiT po\$+s in +His F0lDEr";
$lang['messagewasnotfound'] = "m3ss@GE %s W@S NOt PHouND";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "s3ND Em@1l t0 %s";
$lang['nouserspecifiedforemail'] = "no U\$ER sP3cif1eD PhoR em@1l1ng.";
$lang['entersubjectformessage'] = "eN+ER 4 5u8jeC+ Ph0R tHE M3\$s49e";
$lang['entercontentformessage'] = "ent3r \$0Me C0ntent f0R +3h m3\$s49E";
$lang['msgsentfromby'] = "tHIs ME\$5@9e W4S 53nT from %s 8y %s";
$lang['subject'] = "sUBJ3c+";
$lang['send'] = "seNd";
$lang['userhasoptedoutofemail'] = "%s H@5 OPt3D ouT 0f em@1L Con+4c+";
$lang['userhasinvalidemailaddress'] = "%s H4S 4n InV@liD 3Mail @Ddr35s";
$lang['useemailaddrtosendmsg'] = "u\$e mY r3@l 3m41L 4DDr3Ss +0 sEND TH1S m3\$Sa93";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "mEsS@GE no+1f1c4T1ON pHR0m %s";
$lang['msgnotificationemail'] = "heLlO %s,\n\n%s PO5+ed 4 ME\$S4ge +O j00 ON %s.\n\n+h3 SU8JEc+ iS: %s.\n\nT0 re4D ThA+ mesS49E @ND o+H3R\$ 1n th3 S4M3 d1ScuS\$10n, go to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNo+e: 1F J00 do nO+ wISh to R3cEIVe eM@1l noT1pH1C4+10ns 0Ph pH0Rum m3\$\$@9eS p0\$+3d T0 Y0U, 9o t0: %s CLICk On mY c0n+RolS +H3n 3m4iL 4nd PRivacy, uNs3l3C+ +Eh 3M@1l NotiPHIC4TIoN check80x 4nd PR3sS SUBm1t.";

// Thread Subscription notification ------------------------------------

$lang['threadsubnotification_subject'] = "suBScR1PTiOn noTIf1c4t1on PHrOm %s";
$lang['threadsubnotification'] = "hELLo %s,\n\n%s p0s+ed @ m3\$s4G3 iN 4 +Hr3@d j00 H4vE sU85Cri83D +O 0n %s.\n\n+h3 5U8j3Ct i\$: %s.\n\nTo r3ad Th4+ M3s5a93 ANd 0+H3rs 1N th3 54m3 D1scusS10n, 9O +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0t3: 1f j00 DO N0+ WI\$h +O r3c31v3 EM@1l No+1fIC4+iONS of NEW mEssa93\$ iN THi\$ Thr3AD, 9o +0: %s aNd @DJusT yoUr iN+3re\$t LEV3L 4t T3H BoT+0M opH +HE pAGE.";

// Folder Subscription notification ------------------------------------

$lang['foldersubnotification_subject'] = "su85CR1p+ION n0+1f1c4tiON froM %s";
$lang['foldersubnotification'] = "h3Ll0 %s,\n\n%s p0\$+3D @ MesSA9e 1N A FoLD3R j00 4R3 \$UBscriBed +0 on %s.\n\nTh3 \$U8JEC+ i\$: %s.\n\n+0 r3@D Th@t m3ss4gE @nd o+h3r5 1n THE S@me d1scussI0n, 9o TO:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNo+e: 1f J00 DO N0+ WISH tO R3C31v3 em@1L N0+1f1c4tIONS 0pH NEw MEs54geS 1n TH15 tHr34D, Go T0: %s 4nD adJUS+ Y0UR IN+3re\$T lEV3l bY cl1ck1nG 0n +H3 PH0lder'\$ 1coN @t +H3 Top OF p4ge.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm N0+1fic4+1on phR0M %s";
$lang['pmnotification'] = "hELlo %s,\n\n%s P05t3d 4 pm TO J00 ON %s.\n\ntHe subJ3C+ iS: %s.\n\nT0 re@d +3h messA9e G0 +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0+3: 1F j00 d0 no+ wish +0 recEiv3 Em@1l n0T1phiC@+iOnS OF N3w pm Me\$S4Ge\$ p0s+ed +0 you, Go tO: %s cL1ck MY C0ntr0ls +h3n EM@1l 4ND PR1vACy, unSEl3cT +H3 pm No+1FIc4+10N cH3Ck80x 4ND Pres5 \$Ubm1t.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p4sSW0Rd Chan9E n0+1ph1C4Ti0n phr0m %s";
$lang['pwchangeemail'] = "h3lL0 %s,\n\n+his a no+1fiC4+1on 3MaiL +0 1NPh0RM j00 +h@t y0Ur P@ssw0rd ON %s h4S 833N CH4N93D.\n\nI+ h4S 8e3n Ch4n9Ed to: %s 4ND w45 Ch4ngeD by: %s.\n\n1ph j00 h4v3 recEIVEd +HIs emaIL in errOr OR w3r3 n0t 3XP3c+in9 4 ch4ng3 +0 your p@ssw0Rd ple4Se cont@ct TH3 FORum Own3r 0r 4 M0d3R@+Or oN %s 1MMed14tELy +0 corREc+ 1T.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "eM41l confirma+1ON R3Qu1reD f0r %s";
$lang['confirmemail'] = "h3ll0 %s,\n\ny0u r3c3n+ly cre4t3D 4 NEw us3r 4CC0unt On %s.\n\nB3f0r3 J00 C4n S+4r+ POst1NG We neEd +O CoNPh1rM youR eM4il @DDr3sS. Don'+ W0rrY +h1S is QU1t3 3@5y. 4Ll j00 neeD to Do 1s Cl1Ck tH3 L1nk 8eLOW (0r copy @Nd p4st3 IT 1n+0 YoUr Br0wSEr):\n\n%s\n\n0Nce C0npHIRM4+1oN is COmplE+e J00 M4Y lOg1n @nd sT@Rt pOS+1ng IMM3dI4teLy.\n\n1f j00 d1D noT cre4t3 @ u\$er ACcoun+ On %s ple4\$e 4CCep+ OUr 4P0l09ies 4Nd Ph0rw4Rd +hI5 3M41l +0 %s So ThA+ TEH 5oUrc3 OF 1t maY 83 1nV3sTI94+3d.";
$lang['confirmchangedemail'] = "heLL0 %s,\n\nyOU r3cently chan9ed youR 3m4il On %s.\n\nb3f0R3 J00 c4n \$T4R+ P0\$+in9 4941n W3 NeEd t0 c0nfIRm your N3W EM@1l 4ddr3\$s. d0n't wORry +H1S I\$ Quit3 3A5y. 4ll j00 ne3D To D0 I\$ CLIck tH3 link 83L0w (0r cOpy ANd pA\$+e 1+ 1nT0 yOur br0wSEr):\n\n%s\n\nonC3 CONphIRm4t1oN i5 ComPl3T3 J00 mAY cOnt1nue t0 uS3 +h3 F0Rum 4s n0rM4l.\n\n1F j00 W3RE nOt 3Xp3c+1N9 THIs 3m4il FR0M %s PLeaSE @cCEP+ OuR 4pOLoG1e\$ 4Nd ph0RW4rd +hI\$ 3M4iL TO %s \$0 tHa+ +H3 S0Urc3 0F it m4Y b3 1nVE\$tig4+Ed.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3lLo %s,\n\nYOU r3qu3sT3D tHIs 3-m4il fr0M %s 8EC@use j00 h@VE PHORgo+T3N your P@\$\$word.\n\nClick TH3 l1NK 83L0w (0R c0PY ANd p4\$+3 1+ INt0 y0ur br0W5ER) +0 Re5et y0Ur p4sSWord:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "n3W u\$ER 4PPrOVal No+1F1c4+1ON ph0R %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"OR clicK ThE l1nk b3L0w:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNo+e: o+h3r 4dm1N1\$+R4TOrs 0N +h1s f0RUM will alSO ReCeiVe tHIs N0+1f1Cat10n 4nd m4y h4ve @lre4dY @CTed Up0n thI5 Reque\$T.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "n3W uSEr @cCount noTIf1c4T10n PHor %s";
$lang['newuserregistrationemail'] = "h3LlO %s,\n\n@ N3W U\$3r 4CC0UN+ HA\$ B33n cRE4t3D ON %s.\n\ntO View tHiS Us3r 4cc0unt PL3@Se v1sI+ tH3 4dM1n UsERS SeC+1oN 4nD cL1ck 0n +h3 new u5eR 0R CL1ck the lINk B3l0w:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "uSER 4pprOV@l N0+1fIC4+1oN for %s";
$lang['useraccountapprovedemail'] = "h3Ll0 %s,\n\nYour UsER 4Cc0Un+ 4+ %s H4S B33N 4pPRoved. J00 c4n l091N 4ND \$tar+ p0s+Ing 1Mmed14tely bY cLICkIn9 +h3 l1nk 83L0W:\n\n%s\n\n1F j00 wer3 n0t 3XPeC+1N9 +H1\$ Em@1l PHr0M %s ple4s3 @ccEP+ our AP0l0G1ES @nD FOrwARd +h1s Em4Il to %s so Th@T tEH \$0Urc3 0pH i+ M4Y bE 1nvE\$tIG@TED.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "po\$+ 4ppR0v4l nOt1fIc4+ion Ph0r %s";
$lang['newpostapprovalemail'] = "h3llo %s,\n\nA NeW Pos+ ha\$ B33n crea+ed 0n %s.\n\n@\$ J00 ar3 4 m0D3R@+0r 0N +hiS phoRUm j00 ar3 r3Qu1red To 4ppr0ve th1s P0\$t 83ph0re iT c@N 83 RE@d By O+h3r us3r\$.\n\ny0U C@N 4pPr0ve +h1s P0s+ 4nd 4NY 0+H3r5 p3Nd1N9 APpr0v@L 8Y VIsiT1N9 +HE @dmin PoS+ @ppR0v4l \$3C+1oN Of y0ur pH0rum oR 8y CL1ckIn9 T3h LINK B3lOw:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: 0+H3R adM1niStR4TorS on th1\$ pH0ruM w1lL 4L\$0 R3C31Ve +hIs No+1PHic4tI0N 4Nd m4Y H4vE 4LReaDY Act3D UpOn +Hi5 reqUE\$T.";

// Forgotten password form.

$lang['passwdresetrequest'] = "y0uR p@\$SW0RD R3\$eT Reque\$t phrom %s";
$lang['passwdresetemailsent'] = "p4\$SWORD ReS3+ e-M4IL \$En+";
$lang['passwdresetexp'] = "j00 5h0uld \$horTLy R3ce1v3 @n 3-m41l c0nt41N1NG Ins+ruct1oNs f0r r3\$Et+1n9 Y0UR p45sword.";
$lang['validusernamerequired'] = "a V4l1D u5ERN4me is R3quir3d";
$lang['forgottenpasswd'] = "for9OT p4ssw0rd";
$lang['couldnotsendpasswordreminder'] = "coULd nOT SENd p@s\$w0rd ReMinder. plE4sE c0NT4cT +he forum owNEr.";
$lang['request'] = "r3qU3\$t";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "em41L c0nf1RM4+ION";
$lang['emailconfirmationcomplete'] = "th4NK J00 f0r c0nFirmINg y0ur 3m4Il 4ddreS5. j00 m4y n0w LOg1n ANd s+4r+ p05TIng IMM3Di4teLY.";
$lang['emailconfirmationfailed'] = "em4iL c0Nf1RM@t1on h@S F41LeD, pL3@Se +Ry ag4IN l4tEr. 1ph j00 encoUNT3r tHIs 3rr0R Mult1pl3 t1me\$ PL3@Se C0nTac+ Th3 forum OWn3R or @ Moder4+0R phoR 4s\$1\$+4Nce.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "tOp L3v3l";
$lang['maynotaccessthissection'] = "j00 m@y NOt Acc3\$s +h1S SEcti0n.";
$lang['toplevel'] = "t0p LeV3L";
$lang['links'] = "lINK\$";
$lang['externallink'] = "eX+ern4l L1Nk";
$lang['viewmode'] = "view M0de";
$lang['hierarchical'] = "h1eR4rChic4l";
$lang['list'] = "lISt";
$lang['folderhidden'] = "th1S fOLder i\$ H1ddEN";
$lang['hide'] = "hiD3";
$lang['unhide'] = "unhid3";
$lang['linksdelexp'] = "en+rI3s 1N @ D3LeteD phOlD3r w1LL B3 moved +0 +he p@r3n+ folder. 0nly PhOLd3rs Wh1Ch d0 NOt C0n+A1N SU8F0LdeRS m@Y 83 d3LeteD.";
$lang['listview'] = "l1\$+ VIeW";
$lang['listviewcannotaddfolders'] = "c@Nn0+ 4DD foldER\$ IN +hi5 v1ew. \$How1N9 20 3NTries a+ @ +im3.";
$lang['rating'] = "rA+1NG";
$lang['nolinksinfolder'] = "n0 linK5 iN +HIS Ph0Ld3r.";
$lang['addlinkhere'] = "aDd l1nk h3r3";
$lang['notvalidURI'] = "tH4+ 1s NO+ @ v@L1d uR1!";
$lang['mustspecifyname'] = "j00 mu\$+ spec1Fy 4 nAME!";
$lang['mustspecifyvalidfolder'] = "j00 mus+ \$Pec1FY 4 V4L1d pholD3r!";
$lang['mustspecifyfolder'] = "j00 muST sP3c1FY 4 PholD3R!";
$lang['successfullyaddedlinkname'] = "sUCc3ssFUlly 4dDEd l1Nk '%s'";
$lang['failedtoaddlink'] = "fail3d tO 4dD liNK";
$lang['failedtoaddfolder'] = "f@Il3d tO 4dd ph0lder";
$lang['addlink'] = "adD 4 L1Nk";
$lang['addinglinkin'] = "aDd1ng l1NK 1n";
$lang['addressurluri'] = "addREss";
$lang['addnewfolder'] = "aDd 4 N3W pH0Lder";
$lang['addnewfolderunder'] = "aDd1nG new FoLdEr und3r";
$lang['editfolder'] = "ed1t Folder";
$lang['mustchooserating'] = "j00 Mu\$t cHO0\$E @ RA+1nG!";
$lang['commentadded'] = "y0uR c0Mm3nt w4\$ adD3D.";
$lang['commentdeleted'] = "cOmM3nT W4S D3L3tEd.";
$lang['commentcouldnotbedeleted'] = "coMMen+ CoulD No+ 8e del3+3D.";
$lang['musttypecomment'] = "j00 mu5T +yP3 4 c0mM3Nt!";
$lang['mustprovidelinkID'] = "j00 MusT pr0v1de a l1NK 1D!";
$lang['invalidlinkID'] = "iNv4lid LInk id!";
$lang['address'] = "adDR3\$s";
$lang['submittedby'] = "sUbm1++3d 8Y";
$lang['clicks'] = "cl1CK5";
$lang['rating'] = "r@+1N9";
$lang['vote'] = "v0t3";
$lang['votes'] = "v0T3\$";
$lang['notratedyet'] = "nO+ r4ted 8Y 4NY0NE y3+";
$lang['rate'] = "r4t3";
$lang['bad'] = "b@d";
$lang['good'] = "g00D";
$lang['voteexcmark'] = "v0T3!";
$lang['clearvote'] = "cLe4r V0te";
$lang['commentby'] = "comMEn+ BY %s";
$lang['addacommentabout'] = "aDd @ cOMM3n+ AB0ut";
$lang['modtools'] = "mOd3R@T1oN +00Ls";
$lang['editname'] = "edi+ NAme";
$lang['editaddress'] = "eDI+ @dDr3ss";
$lang['editdescription'] = "eD1+ D35crIPt1ON";
$lang['moveto'] = "m0VE +0";
$lang['linkdetails'] = "l1nK de+4iLs";
$lang['addcomment'] = "aDd c0MM3N+";
$lang['voterecorded'] = "your Vote h45 b3EN R3CoRDEd";
$lang['votecleared'] = "y0uR vo+E ha\$ 8e3n clear3D";
$lang['linknametoolong'] = "liNk n4M3 to0 lOn9. m@X1MuM 1s %s Ch4r4C+er\$";
$lang['linkurltoolong'] = "linK url tO0 L0n9. m4XImUm iS %s ch4r4cT3r\$";
$lang['linkfoldernametoolong'] = "foLd3R Name +00 lOn9. m4xImum Length i\$ %s Ch@r4C+eRS";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 l0g93d In SUCCes\$fully.";
$lang['presscontinuetoresend'] = "preS\$ ContINU3 to r3senD fORm D@tA or c@nC3l to ReL04D P@Ge.";
$lang['usernameorpasswdnotvalid'] = "tHE uSeRN@m3 or p4ssW0Rd j00 Suppl1ed 1S n0+ v@lId.";
$lang['youhavesuccessfullyloggedout'] = "j00 h@V3 5UCCE\$sphuLLY L0G9Ed 0u+.";
$lang['rememberpasswds'] = "reMEMb3r Pa\$sw0rDs";
$lang['rememberpassword'] = "r3M3mB3r PAssw0rd";
$lang['logmeinautomatically'] = "lO9 m3 1n AUt0m@+ic4lly";
$lang['enterasa'] = "enTEr 4s 4 %s";
$lang['donthaveanaccount'] = "don'+ H4v3 @n @cC0Un+? %s";
$lang['registernow'] = "re91\$+3R now";
$lang['problemsloggingon'] = "pRo8LEms l0991ng on?";
$lang['deletecookies'] = "d3L3T3 c00k13S";
$lang['cookiessuccessfullydeleted'] = "c00K13s SUCc3S5fullY DEl3+3D";
$lang['forgottenpasswd'] = "f0r9o+T3N your P@s\$worD?";
$lang['usingaPDA'] = "u\$1N9 4 pd4?";
$lang['lightHTMLversion'] = "liGHt hTMl vers10n";
$lang['logonbutton'] = "l09oN";
$lang['otherdotdotdot'] = "o+H3R&hellip;";
$lang['yoursessionhasexpired'] = "yOUR 5eSSi0N h4\$ expir3d. j00 w1LL neeD +0 l0g1n AG4IN to C0ntInu3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my F0rum\$";
$lang['allavailableforums'] = "alL 4v@Il4Bl3 foRUm\$";
$lang['favouriteforums'] = "f4Vour1t3 pH0RUms";
$lang['ignoredforums'] = "igN0Red FORUm\$";
$lang['ignoreforum'] = "i9N0Re pHOrum";
$lang['unignoreforum'] = "unI9noR3 PH0rum";
$lang['lastvisited'] = "lAsT v1S1+3D";
$lang['forumunreadmessages'] = "%s UnrE@d m355@9e\$";
$lang['forummessages'] = "%s ME\$S493s";
$lang['forumunreadtome'] = "%s Unr34D &quot;+0: M3&quot;";
$lang['forumnounreadmessages'] = "nO unR34d m35s493S";
$lang['removefromfavourites'] = "rEmoVE FroM Ph4v0UR1+3\$";
$lang['addtofavourites'] = "adD TO ph@V0UR1t3S";
$lang['availableforums'] = "av@1labL3 forum5";
$lang['noforumsofselectedtype'] = "tHer3 4r3 n0 f0rumS 0PH Th3 sel3CteD type AV@1l48le. ple4sE \$El3C+ 4 diff3REnt +Ype.";
$lang['successfullyaddedforumtofavourites'] = "sUccES\$fULLy @dDeD forUM t0 PHavour1te5.";
$lang['successfullyremovedforumfromfavourites'] = "sUcCESspHUlly rEMOveD Ph0rum fr0M F4v0URIT35.";
$lang['successfullyignoredforum'] = "suCCe\$sphulLY I9n0r3d phoRuM.";
$lang['successfullyunignoredforum'] = "suCC3SSFUlLY un1gn0R3d PhoRuM.";
$lang['failedtoupdateforuminterestlevel'] = "fa1leD to UPD@te PHorum iN+3rE\$t L3veL";
$lang['noforumsavailablelogin'] = "tHERe 4Re no PH0RumS 4V4ILABL3. pl3AS3 L0G1N +0 V13w Y0ur FOrUm\$.";
$lang['passwdprotectedforum'] = "p@\$SW0rd prOt3CT3D FOrum";
$lang['passwdprotectedwarning'] = "tHI\$ forum 1S p@5\$word pr0+ect3D. +0 94in 4Cc3s\$ Ent3r +3h P4SsW0rD beLOw.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "pO\$t M3\$s4Ge";
$lang['selectfolder'] = "sELEc+ F0lder";
$lang['mustenterpostcontent'] = "j00 Mu\$T en+er S0ME C0Nt3n+ Ph0r +He p0st!";
$lang['messagepreview'] = "mESs493 preview";
$lang['invalidusername'] = "inv4lid useRN@me!";
$lang['mustenterthreadtitle'] = "j00 mu\$t 3NTer 4 titl3 f0r t3h thre4d!";
$lang['pleaseselectfolder'] = "plE4se SEl3c+ 4 pH0LDEr!";
$lang['errorcreatingpost'] = "eRr0R Cr3a+1n9 P0\$+! pl34\$E tRY 4G4in in @ feW mInu+es.";
$lang['createnewthread'] = "cRE4+3 n3w +hr3ad";
$lang['postreply'] = "posT rePLy";
$lang['threadtitle'] = "tHr3AD +1tle";
$lang['foldertitle'] = "f0lD3r ti+L3";
$lang['messagehasbeendeleted'] = "meSS@ge NOT F0und. ch3Ck TH@t 1t h@Sn'T b33n dEl3+ed.";
$lang['messagenotfoundinselectedfolder'] = "m3ss@Ge nO+ PH0und in \$EL3ct3d fOlD3r. CheCk Th4+ 1+ H4\$N'+ 8een mOV3D or deL3+ed.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c4nn0+ Post +h1\$ thr34D +yPE iN Th@T foldEr!";
$lang['cannotpostthisthreadtype'] = "j00 CAnn0t P0S+ +his +hR3ad TYp3 45 +h3r3 4re n0 @v41laBl3 foLDErS +h4+ @Ll0w 1+.";
$lang['cannotcreatenewthreads'] = "j00 c4NNot Cr3ate N3W +Hr3@D5.";
$lang['threadisclosedforposting'] = "tHiS thre4d is Cl05eD, J00 c@nno+ po5t in 1t!";
$lang['moderatorthreadclosed'] = "w4rN1n9: +h1s +Hr3@D is Cl0\$ed F0R p0\$TIN9 to nORm4L US3r\$.";
$lang['usersinthread'] = "uS3Rs in Thr3ad";
$lang['correctedcode'] = "c0rR3C+ed c0d3";
$lang['submittedcode'] = "submit+3d code";
$lang['htmlinmessage'] = "h+ml 1n M3\$S4ge";
$lang['disableemoticonsinmessage'] = "d1S48Le 3m0+Ic0nS";
$lang['automaticallyparseurls'] = "aUtOm@TIc4Lly P4rSe urlS";
$lang['automaticallycheckspelling'] = "aUtOM4Tic4Lly ch3Ck SP3lL1n9";
$lang['setthreadtohighinterest'] = "seT thread +0 h19h 1nTer3S+";
$lang['enabledwithautolinebreaks'] = "en48LED W1+H @uTo-L1n3-bReak\$";
$lang['fixhtmlexplanation'] = "tH15 ph0Rum U5Es H+Ml FIlT3rin9. YOUr SUbmI++3D HTMl h4s 8e3n MoD1f1ED By T3h F1l+3rs 1n 5OM3 w4Y.\n\n+o vi3w YOuR 0ri91nal c0de, 5eL3ct th3 '5UBmITtED coDe' r4dI0 8ut+0n.\ntO vI3W +eh moDifi3d Code, 53lEc+ +Eh 'cORrEc+eD CoD3' R@D10 8ut+0n.";
$lang['messageoptions'] = "meSs49e 0pTI0ns";
$lang['notallowedembedattachmentpost'] = "j00 4r3 NO+ @LLoweD tO 3m83d 4+tAChmEnts 1n YOuR P0\$t\$.";
$lang['notallowedembedattachmentsignature'] = "j00 @RE nO+ 4llOWeD to 3MbeD 4+T@cHM3NTs in Y0ur S1gn@ture.";
$lang['reducemessagelength'] = "meSs4ge len9th MU\$+ 83 und3r 65,535 Ch4R4CterS (Curren+LY: %s)";
$lang['reducesiglength'] = "siGn4+ur3 leng+h mus+ 8e unDer 65,535 ch4rac+3Rs (curren+ly: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 c4nnO+ cr34t3 NEw thr3@ds in This Ph0LdeR";
$lang['cannotcreatepostinfolder'] = "j00 c@Nnot R3plY T0 p0\$+5 IN +h1S ph0ldeR";
$lang['cannotattachfilesinfolder'] = "j00 c@Nnot po\$t 4++4ChM3n+S iN Th1s PH0LDer. RemoV3 a+t4chm3nts TO c0N+Inu3.";
$lang['postfrequencytoogreat'] = "j00 can 0NLy p0\$T 0nce 3vEry %s Sec0nD5. pL3a\$e +ry 4g4IN L@tER.";
$lang['emailconfirmationrequiredbeforepost'] = "em@1L C0NPh1rm4tion 15 Requ1r3D 83ph0re j00 C@N pO\$T. 1PH j00 h4v3 nOT r3Ceiv3D 4 c0nphirM@t1on 3m@1L pl34se cl1ck +eh 8utTOn 8Elow 4Nd 4 n3W on3 w1ll 83 S3n+ +0 yOU. 1f Y0UR em4il 4dDres5 n33D\$ Ch@nG1NG PLEase do So b3F0R3 REqu3\$Tin9 a new conPHirM@T1oN 3M4Il. j00 M4Y cH@N93 Your EM41l @ddr3\$s By cl1ck My CON+RoLs A8Ov3 @Nd +h3n U\$ER de+41lS";
$lang['emailconfirmationfailedtosend'] = "coNpHIrm@Ti0n 3m4IL fa1L3d tO seNd. pLe4se C0nt4cT +hE Ph0RUM oWNeR +O rec+1fY this.";
$lang['emailconfirmationsent'] = "conFirm@T10N 3M4IL h4\$ 8Een r3\$3Nt.";
$lang['resendconfirmation'] = "re5END ConpHIrm4t1ON";
$lang['userapprovalrequiredbeforeaccess'] = "yoUr U5ER 4cC0UNT n3Ed\$ +o b3 @pPR0Ved 8y 4 f0RuM @dMIN B3ph0R3 J00 C4n @CcE\$s +eh reQUe\$TEd FOrum.";
$lang['reviewthread'] = "reV1EW Thre4d";
$lang['reviewthreadinnewwindow'] = "r3VieW En+1re Thre@D 1n N3W w1nd0W";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN R3Ply +0";
$lang['showmessages'] = "sH0w mes\$4Ge5";
$lang['ratemyinterest'] = "r4+e My iN+er3\$t";
$lang['adjtextsize'] = "adjUST +EXT \$1Z3";
$lang['smaller'] = "smALLEr";
$lang['larger'] = "l4Rg3r";
$lang['faq'] = "f4q";
$lang['docs'] = "doc5";
$lang['support'] = "suPpOrt";
$lang['donateexcmark'] = "d0NA+E!";
$lang['fontsizechanged'] = "f0nT s1ze cH4N9ED. %s";
$lang['framesmustbereloaded'] = "fRame\$ must 83 REl04deD M@nu4LLy +0 \$EE ch4n9e\$.";
$lang['threadcouldnotbefound'] = "thE rEQUes+3d thr3aD c0Uld noT 83 FOund or 4cC3\$\$ w4s D3n1eD.";
$lang['mustselectpolloption'] = "j00 Mu\$+ seleCt @N 0PTi0n t0 vO+e ph0r!";
$lang['mustvoteforallgroups'] = "j00 mu\$T vote in 3veRY 9RoUP.";
$lang['keepreadingdotdotdot'] = "ke3p RE@D1Ng&hellip;";
$lang['backtothreadlist'] = "b4CK tO +hr3@D L1\$+";
$lang['postdoesnotexist'] = "th@T P05+ Doe\$ n0+ 3X1s+ 1n This +hre4d!";
$lang['clicktochangevote'] = "cLiCk +O ch4n9e vOTe";
$lang['youvotedforoption'] = "j00 VotED phOR opT1oN";
$lang['youvotedforoptions'] = "j00 V0+Ed ph0R Op+IonS";
$lang['clicktovote'] = "cL1Ck +0 Vo+3";
$lang['youhavenotvoted'] = "j00 HAve n0t V0+ed";
$lang['viewresults'] = "v13W r3sUL+\$";
$lang['msgtruncated'] = "mES\$4GE Trunc@TEd";
$lang['viewfullmsg'] = "vI3W Phull meS54ge";
$lang['ignoredmsg'] = "i9N0red me\$s4G3";
$lang['wormeduser'] = "w0RMed us3R";
$lang['ignoredsig'] = "iGNorEd s19n4+ure";
$lang['messagewasdeleted'] = "mE5\$4g3 %s.%s WA\$ D3l3+ed";
$lang['stopignoringthisuser'] = "sToP 1gnoRIng this u5Er";
$lang['renamethread'] = "r3n@Me thR3@D";
$lang['movethread'] = "m0v3 +Hre4D";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 r3n4me +His +HRE@D j00 mus+ 3Di+ +h3 p0ll.";
$lang['closeforposting'] = "cl053 foR pOSTIN9";
$lang['until'] = "un+iL 00:00 utc";
$lang['approvalrequired'] = "aPproVal r3QUiR3D";
$lang['messageawaitingapprovalbymoderator'] = "m3\$s@G3 %s.%s is 4w4it1ng 4pPRov4l by 4 m0deRA+oR";
$lang['successfullyapprovedpost'] = "suCCEs\$fULLy 4Ppr0VEd p0s+ %s";
$lang['postapprovalfailed'] = "po\$t APpROv4L F@1lED.";
$lang['postdoesnotrequireapproval'] = "p0S+ do3\$ N0t requIRe @Ppr0V4L";
$lang['approvepost'] = "apProv3 po5t";
$lang['approvedbyuser'] = "aPPRov3d: %s By %s";
$lang['makesticky'] = "make st1cKY";
$lang['messagecountdisplay'] = "%s of %s";
$lang['linktothread'] = "p3Rm4NEnt LInk tO Thi\$ +HRe4d";
$lang['linktopost'] = "l1nk to pOSt";
$lang['linktothispost'] = "linK +0 +hiS po5+";
$lang['imageresized'] = "tH1S 1m493 h4s B33n R3siz3D (or191NAl \$1ze %dX%d). +0 v1Ew ThE Full-s1Z3 1m4GE CLick HER3.";
$lang['messagedeletedbyuser'] = "m3SS4GE %s.%s D3l3+3D %s by %s";
$lang['messagedeleted'] = "me\$S49E %s.%s w4s deL3t3d";
$lang['viewinframeset'] = "vI3w 1n FR@mE\$eT";
$lang['pressctrlentertoquicklysubmityourpost'] = "pr3SS c+RL+eNt3r TO Qu1CKlY subm1t y0ur PoS+";
$lang['invalidmsgidornomessageidspecified'] = "iNv4l1D MEss@Ge iD or no MeSs@9e 1D 5p3CiPHiED.";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "caNnO+ diSPL4y F0lder M0d3r@+0rS";
$lang['moderatorlist'] = "mOdER@t0R liS+:";
$lang['modsforfolder'] = "m0d3r@T0R\$ pH0r ph0ldEr";
$lang['nomodsfound'] = "n0 moder@T0r5 phOunD";
$lang['forumleaders'] = "foRum l3Ad3Rs:";
$lang['foldermods'] = "foLd3R MoDer@TOrs:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+4r+";
$lang['messages'] = "m3\$\$@9E\$";
$lang['pminbox'] = "inboX";
$lang['startwiththreadlist'] = "staRT p@93 w1+h thREaD l1s+";
$lang['pmsentitems'] = "seN+ IT3M\$";
$lang['pmoutbox'] = "oUt80x";
$lang['pmsaveditems'] = "s4v3d 1t3m\$";
$lang['pmdrafts'] = "dr@PhtS";
$lang['links'] = "liNks";
$lang['admin'] = "admin";
$lang['login'] = "l0g1n";
$lang['logout'] = "lo9OUt";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pRIVATe M35s@9e\$";
$lang['recipienttiptext'] = "s3P4RA+e r3cip1En+S By sem1-C0L0n OR cOmma";
$lang['maximumtenrecipientspermessage'] = "tH3re 1\$ 4 LIMit 0f 10 R3C1PI3n+5 p3r mesS4G3. PL3aSe @MeNd your rec1P13n+ Lis+.";
$lang['mustspecifyrecipient'] = "j00 musT spEcIfY 4+ L3aS+ One RecIP13n+.";
$lang['usernotfound'] = "uS3r %s n0+ phound";
$lang['sendnewpm'] = "senD n3w pm";
$lang['saveselectedmessages'] = "saVe 5el3CteD meS54GEs";
$lang['exportselectedmessages'] = "exPor+ Sel3c+ED mess@gE\$";
$lang['nosubject'] = "n0 SU8j3ct";
$lang['norecipients'] = "n0 reC1pIEn+\$";
$lang['timesent'] = "tim3 SEn+";
$lang['notsent'] = "n0t sent";
$lang['errorcreatingpm'] = "erR0R cR3ATin9 pm! ple4Se +RY 4gA1n 1n A fEW minu+eS";
$lang['writepm'] = "wR1T3 ME\$S49E";
$lang['editpm'] = "ediT M3Ssa93";
$lang['cannoteditpm'] = "c4NNo+ 3dit +h1\$ PM. 1T h4S @Lr3@Dy 833n V1eW3d 8y +he r3Cip1eN+ Or +HE Mess@ge DOe5 n0+ eXIs+ 0r IT i\$ IN4Cc35s18L3 8y j00";
$lang['cannotviewpm'] = "c4NN0T v13W Pm. M35sA9e D03s not 3xISt OR it Is in4Cc3S518Le By j00";
$lang['pmmessagenumber'] = "m3s\$@9E %s";

$lang['youhavexnewpm'] = "j00 HAvE %d new mEs54gE5. w0Uld j00 lik3 +O 9o to y0Ur InBox n0w?";
$lang['youhave1newpm'] = "j00 HAVe 1 n3w m3\$S4gE. w0uld j00 Lik3 +O 90 +O yOUr 1n80X n0w?";
$lang['youhave1newpmand1waiting'] = "j00 h4v3 1 N3W m3\$\$4G3.\n\nYoU 4lsO have 1 m3s54GE @w@itinG d3L1veRy. +0 reC31v3 +HiS m3\$s4gE ple@SE cLeAr SOme Sp4ce 1N y0UR INBox.\n\nW0ULD j00 Lik3 +O gO to Y0ur 1N80X n0W?";
$lang['youhave1pmwaiting'] = "j00 haVE 1 m3\$s49E @w@1+1NG D3liv3ry. +0 r3c31VE +HIs MEss493 Pl34S3 Cle4R S0Me sp4C3 In yOUr 1nBoX.\n\nWould j00 l1ke t0 g0 +0 YouR inBoX N0W?";
$lang['youhavexnewpmand1waiting'] = "j00 H@V3 %d n3W ME55AGes.\n\nY0u 4LSo h@v3 1 M3S\$4GE @w41+1n9 D3liv3RY. TO r3Ceiv3 +hi5 m3sS@93 pl34Se cle4R \$oMe SP4C3 1N yOur 1n80x.\n\nwOUlD j00 likE +0 Go +0 y0ur in80x N0W?";
$lang['youhavexnewpmandxwaiting'] = "j00 H4v3 %d new mes\$493\$.\n\nyou 4LS0 H4v3 %d MEss@93\$ 4W41tin9 dEliv3ry. +0 rEc31v3 +H3\$e M3S549e pL34sE cl34R 50mE \$p@c3 In y0ur InBoX.\n\nW0Uld j00 l1Ke +O go to yOuR 1nBox N0w?";
$lang['youhave1newpmandxwaiting'] = "j00 h4v3 1 n3W M3\$Sa93.\n\ny0U 4Ls0 have %d M3\$s4Ge\$ 4w41+iNG D3l1v3RY. +o r3Ce1v3 th35e m3ss4g3s pLE@5E cle4R s0me sp4ce in y0ur INbOX.\n\nW0uLd j00 lik3 tO 90 TO YOur inbox NoW?";
$lang['youhavexpmwaiting'] = "j00 H4ve %d m3\$S4Ges @w@1t1n9 DelIVery. +0 REcE1v3 +h3S3 M35s49E\$ ple45E cle4r \$OME sp@c3 1n y0ur 1nB0x.\n\nW0ULd J00 like tO 9O TO yoUR 1NBoX n0w?";

$lang['youdonothaveenoughfreespace'] = "j00 d0 N0+ h4ve 3n0UgH fr33 Sp4c3 to senD th1S MEs\$4GE.";
$lang['userhasoptedoutofpm'] = "%s h4s op+3D 0uT 0f RECeiv1ng P3R5ON4l m3\$s4G3s";
$lang['pmfolderpruningisenabled'] = "pm pH0lder prunin9 1S en@8L3D!";
$lang['pmpruneexplanation'] = "thiS foRuM us35 pm pholdeR pruniNG. tH3 mES\$4gE\$ j00 H4VE st0r3d in Y0ur 1n80X 4nd 53nT i+3MS\nf0Lder\$ 4RE subJ3C+ +o @U+0M4+1c d3LeTI0n. 4Ny mes\$4gE\$ J00 W1\$h To keep \$HOULD 8e m0Ved +0\nY0ur 'S4ved 1tems' fOLD3R \$o tH@t +h3Y 4r3 nO+ Del3+3d.";
$lang['yourpmfoldersare'] = "youR pM f0ldeR5 4r3 %s pHuLL";
$lang['currentmessage'] = "cuRRen+ M3Ss4g3";
$lang['unreadmessage'] = "unr34D mE\$s4G3";
$lang['readmessage'] = "r3AD Me5s@GE";
$lang['pmshavebeendisabled'] = "peRs0NAL m3\$s4g3s H4VE b33n dis48LEd By TH3 FORum 0wn3r.";
$lang['adduserstofriendslist'] = "aDD u\$Er\$ t0 YOuR PHr1Ends liS+ t0 h4vE Th3m @Ppe4R 1n 4 dr0p down oN +he pM wR1t3 m3sS@ge P49e.";

$lang['messagewassuccessfullysavedtodraftsfolder'] = "mES\$4G3 w4\$ \$UCces\$Fully s@v3d To 'dr4PH+s' PH0LDEr";
$lang['couldnotsavemessage'] = "cOuld no+ S4VE m3s\$4ge. M4KE 5Ure j00 haVe 3N0U9h 4v4il48LE FR3e \$pACE.";
$lang['pmtooltipxmessages'] = "%s mES54g3s";
$lang['pmtooltip1message'] = "1 m3\$s4ge";

$lang['allowusertosendpm'] = "aLl0W User to S3nD P3Rson4L Me\$S4G3S +O me";
$lang['blockuserfromsendingpm'] = "bl0CK user fr0m S3Nd1n9 per\$on4l me\$s4GE\$ +0 me";
$lang['yourfoldernamefolderisempty'] = "y0uR %s ph0ld3r 1\$ Empty";
$lang['successfullydeletedselectedmessages'] = "sucC3\$SphUlLY DEl3+3d s3lEct3d M3\$s4G3s";
$lang['successfullyarchivedselectedmessages'] = "sucC3S5fully 4rcHIV3D s3leC+eD mE5S4g3s";
$lang['failedtodeleteselectedmessages'] = "f4IlEd +o d3le+3 sel3c+Ed m3\$s4Ge\$";
$lang['failedtoarchiveselectedmessages'] = "f4ilEd tO 4rcHIv3 5El3c+eD mesS@ge\$";
$lang['deletemessagesconfirmation'] = "are J00 sUR3 J00 w4n+ to dEL3+E @ll oph TEH \$EL3c+ed ME5\$49e\$?";
$lang['youmustselectsomemessages'] = "j00 Mus+ s3lEc+ some m3ss@ge5 +0 proCes\$";
$lang['successfullyrenamedfolder'] = "suCCEssfully REn4mED fOLdEr";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY ConTr0Ls";
$lang['myforums'] = "mY f0rUMs";
$lang['menu'] = "menu";
$lang['userexp_1'] = "u5E TH3 mEnu 0n +eH l3Pht +0 m4na93 Y0ur 5E+T1N9S.";
$lang['userexp_2'] = "<b>uS3r d3+@1L\$</b> @ll0ws j00 T0 Ch@nge Y0ur n@m3, EM@il @dDresS @nd P4SSw0rD.";
$lang['userexp_3'] = "<b>u\$eR PRoFil3</b> ALloWS j00 T0 ed1t your user pROf1Le.";
$lang['userexp_4'] = "<b>cH4n9e p4\$Sw0rD</b> 4Llow\$ J00 t0 cH4N9E y0Ur p@SSword";
$lang['userexp_5'] = "<b>emAil &amp; prIV4cY</b> le+S j00 Ch4N9e hOW j00 can 8e cONt@cT3D 0N 4nD oPHf THE foruM.";
$lang['userexp_6'] = "<b>f0Rum oPt10N\$</b> LE+s j00 cH@N93 h0w +h3 ph0Rum lookS @nD worK\$.";
$lang['userexp_7'] = "<b>a++4ChmeNt5</b> 4llOWS J00 t0 edi+/del3+e y0ur ATt@CHMenT5.";
$lang['userexp_8'] = "<b>si9N4+Ur3</b> L3ts j00 3D1+ y0ur \$1gN@TUr3.";
$lang['userexp_9'] = "<b>rel4tI0Nsh1P5</b> Le+\$ J00 MAN@G3 y0Ur rel@+ionshIP W1+H 0+H3r u\$er5 oN +h3 f0rUm.";
$lang['userexp_9'] = "<b>w0Rd pH1lT3r</b> LET\$ j00 3Dit y0uR PEr5oN4l W0Rd Ph1L+3R.";
$lang['userexp_10'] = "<b>thRe4D 5uBscRiPT10N\$</b> AllowS j00 +0 M@N4G3 Y0UR ThR34d 5uB5Cr1PT10n\$.";
$lang['userdetails'] = "uS3r D3+4IL5";
$lang['emailandprivacy'] = "em41L &amp; pRiVAcY";
$lang['editsignature'] = "ed1T 5IGn4+URE";
$lang['norelationshipssetup'] = "j00 h4v3 n0 U5ER r3l4T1ON\$hIpS 5e+ uP. 4DD A n3W usEr 8y \$34RCHin9 8eL0W.";
$lang['editwordfilter'] = "ed1T W0rD PhilT3r";
$lang['userinformation'] = "u5Er iNphorMA+1on";
$lang['changepassword'] = "ch@n93 p@\$\$WOrd";
$lang['currentpasswd'] = "cUrrENT P@Ssw0rd";
$lang['newpasswd'] = "n3w P@5\$w0rD";
$lang['confirmpasswd'] = "conPHIRM p455w0rD";
$lang['currentpasswdrequired'] = "cuRreN+ p4\$sWOrd IS ReQUiR3D";
$lang['newpasswdrequired'] = "new P4s\$word 1S ReQUiRED";
$lang['confirmpasswordrequired'] = "cOnpH1RM p4\$swoRD iS rEQUir3D";
$lang['currentpasswddoesnotmatch'] = "curR3Nt p4s\$WORd d03s not M4+ch \$4VEd P4sswORd";
$lang['nicknamerequired'] = "nickn4me 1s r3quireD!";
$lang['emailaddressrequired'] = "eM41l addre\$s 1S r3qU1R3d!";
$lang['logonnotpermitted'] = "l0g0n n0T permi++ed. cH0O\$e @n0+HEr!";
$lang['nicknamenotpermitted'] = "n1CKn4m3 NO+ p3RMI++eD. Cho05E @NO+h3R!";
$lang['emailaddressnotpermitted'] = "eM@1l 4dDREs\$ NO+ p3RM1T+3d. cho05e 4no+heR!";
$lang['emailaddressalreadyinuse'] = "em41l 4dDresS alReADy 1n usE. cHO0s3 aNOtHer!";
$lang['relationshipsupdated'] = "rel4+1ONshIPs upd4ted!";
$lang['relationshipupdatefailed'] = "r3L4Ti0n\$hiP Upda+eD F4IL3d!";
$lang['preferencesupdated'] = "pR3F3reNc3\$ w3R3 \$UCC3S\$fULly upD4+ed.";
$lang['userdetails'] = "u\$3R deT4IL\$";
$lang['memberno'] = "mEmbEr N0.";
$lang['firstname'] = "f1rS+ n4M3";
$lang['lastname'] = "l4\$+ N4ME";
$lang['dateofbirth'] = "d@+E 0pH B1r+h";
$lang['homepageURL'] = "hoM3p493 Url";
$lang['profilepicturedimensions'] = "pRoFiLE p1Ctur3 (m@X 95x95Px)";
$lang['avatarpicturedimensions'] = "aV@T@r pIcTUr3 (m@X 15x15PX)";
$lang['invalidattachmentid'] = "inv@l1d 4t+aChment. CHecK tH4+ 1S ha\$n'+ be3n dELe+Ed.";
$lang['unsupportedimagetype'] = "uNSupp0r+3D IMA93 4t+4chm3NT. j00 C4n OnLy uSe jp9, 9iF 4ND Pn9 1mAGE 4tt@CHMents PHor Your Av4taR and propH1le P1CTure.";
$lang['selectattachment'] = "s3l3c+ 4+T@cHM3n+";
$lang['pictureURL'] = "p1ctuR3 urL";
$lang['avatarURL'] = "av4t4r uRL";
$lang['profilepictureconflict'] = "tO u\$E An 4++4chmeN+ f0R youR pRof1le p1CtUR3 ThE pICTur3 url field muSt B3 8l@nk.";
$lang['avatarpictureconflict'] = "to u5E 4n @t+aChmeNT F0R your @v4t4r p1c+Ur3 th3 @v@taR uRl ph1elD mu\$t 83 BL4nk.";
$lang['attachmenttoolargeforprofilepicture'] = "sEleC+3d 4++4cHm3n+ 1s +00 l4R9E ph0R prof1l3 piCture. max1muM DimEns10Ns @R3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "sElec+ED @++4chm3nt IS to0 l4rge fOR 4V4T@r pIcTUr3. M@ximum d1M3N\$10ns @Re %s";
$lang['failedtoupdateuserdetails'] = "soM3 0r aLL 0f Y0ur uS3r 4cC0unt de+@1L5 could n0+ Be updA+Ed. please TrY ag4iN l4T3R.";
$lang['failedtoupdateuserpreferences'] = "s0me Or 4LL oph y0ur usER pr3Ph3r3nCE\$ c0ULd nOT B3 upD4+3d. PLeA\$e +Ry 49@1N l4+3R.";
$lang['emailaddresschanged'] = "eM41l 4ddresS H45 8EEn CH@n93d";
$lang['newconfirmationemailsuccess'] = "yOUR em@il 4dDR3\$\$ H@S 8E3N CH@Ng3d 4nD @ N3W coNPh1rM4TIoN 3m@1l H4\$ 8e3n SEnt. Pl34Se cHeck 4nD Re4d +he 3m@1l pH0R phurtHEr iN\$TrUC+1oNS.";
$lang['newconfirmationemailfailure'] = "j00 H4v3 ch4N9ED Y0ur eM4iL @dDr3\$S, bUt w3 were un@8Le to s3nd 4 conf1rma+10N r3qu35T. pLe4se ConT4ct TeH foRUm owN3R F0r 4Ss1ST@NCE.";
$lang['forumoptions'] = "forUm OpTI0Ns";
$lang['notifybyemail'] = "n0t1Phy by emAIL 0Ph poS+s t0 Me";
$lang['notifyofnewpm'] = "n0TiFY by P0puP 0Ph n3w PM M3\$s4ge\$ T0 ME";
$lang['notifyofnewpmemail'] = "n0t1pHY by Em41L 0f n3w pm M3S\$4ges +o mE";
$lang['daylightsaving'] = "adJu\$+ fOr dayli9H+ \$4VINg";
$lang['autohighinterest'] = "au+0m4t1c4Lly M4Rk ThrEaD\$ 1 PoS+ 1n @s hi9h 1n+3r3\$t";
$lang['sortthreadlistbyfolders'] = "sOr+ +hr34d l1\$T By f0ldERs";
$lang['convertimagestolinks'] = "aU+0m4+1C4lly C0nv3r+ 3m8Edd3d 1m493\$ 1N poS+\$ 1N+0 L1NKs";
$lang['thumbnailsforimageattachments'] = "thuMBN@1l\$ pH0R 1M493 @+t4cHMEnts";
$lang['smallsized'] = "sMALl 51ZED";
$lang['mediumsized'] = "meD1UM S1Z3d";
$lang['largesized'] = "l@rg3 \$1z3D";
$lang['globallyignoresigs'] = "gLOb4lLY 19n0re uSEr S1Gn4+Ur3S";
$lang['allowpersonalmessages'] = "all0W O+h3R uS3R\$ +O SeNd me p3rS0n4l Mess49E\$";
$lang['allowemails'] = "aLlOW O+h3R u53r5 +0 send m3 3m4IL\$ V1@ my pr0File";
$lang['useemailaddr'] = "us3 My 3m4Il @ddR3\$s wh3n \$ENd1ng 0thEr uSEr\$ 3M4iL\$ vi4 THE1r PropH1Le\$";
$lang['timezonefromGMT'] = "tIME Zone";
$lang['postsperpage'] = "pO\$t5 P3R p4GE";
$lang['fontsize'] = "f0nT s1ze";
$lang['forumstyle'] = "foruM 5tyLE";
$lang['forumemoticons'] = "foRUm EmOT1conS";
$lang['startpage'] = "s+4R+ p49E";
$lang['signaturecontainshtmlcode'] = "s19n4+ur3 c0NT41n\$ h+ML cOD3";
$lang['savesignatureforuseonallforums'] = "s4VE \$19n@TuRE ph0r use oN @LL f0ruMS";
$lang['preferredlang'] = "pREPHerr3D L4N9u@9E";
$lang['donotshowmyageordobtoothers'] = "dO NO+ sH0W my @93 OR D4+3 0ph 8ir+h +0 0th3r5";
$lang['showonlymyagetoothers'] = "shoW ONly my a93 +O otHErs";
$lang['showmyageanddobtoothers'] = "sHoW B0+h mY @ge 4nd d4TE 0ph b1r+H +0 OTh3r5";
$lang['showonlymydayandmonthofbirthytoothers'] = "sHOw ONly My d4y @Nd moNTh OPh B1R+h +O o+H3RS";
$lang['listmeontheactiveusersdisplay'] = "l1\$+ me 0n t3h 4ct1V3 Us3r5 diSPL@y";
$lang['browseanonymously'] = "bRoWSe ph0rUM 4Nonym0u\$lY";
$lang['allowfriendstoseemeasonline'] = "bR0wse 4nonymOUsly, Bu+ 4ll0w phr1EnD5 +0 S3e me as onl1N3";
$lang['revealspoileronmouseover'] = "r3VE4l sPO1L3RS on m0usE 0VeR";
$lang['showspoilersinlightmode'] = "alW4y\$ \$HoW spOIl3Rs In ligH+ M0d3 (USe5 ligHTER PhoNt C0l0ur)";
$lang['resizeimagesandreflowpage'] = "rES1z3 1m@93S @nD RePHLow PAgE +0 PR3v3nt hOR1ZOntal ScrOlLIn9.";
$lang['showforumstats'] = "sHOw fORUM st@t\$ 4T 80T+oM 0Ph m3S\$493 p@Ne";
$lang['usewordfilter'] = "en@bl3 w0rD pH1L+3r.";
$lang['forceadminwordfilter'] = "f0rc3 use Of @dMIn w0Rd PHiL+3r on 4LL uSErs (iNC. GuE\$t\$)";
$lang['timezone'] = "t1m3 ZoNe";
$lang['language'] = "laNgU4g3";
$lang['emailsettings'] = "em@il 4nd coN+4c+ \$Ett1n9s";
$lang['forumanonymity'] = "f0Rum 4nonYM1ty Se++IN95";
$lang['birthdayanddateofbirth'] = "b1Rthd4Y 4nD d4+3 of Birth dispL@y";
$lang['includeadminfilter'] = "iNclUd3 4dMIN W0rd Phil+er In MY l15+.";
$lang['setforallforums'] = "sEt F0r @lL forum\$?";
$lang['containsinvalidchars'] = "%s C0N+41n\$ 1nv4l1d Ch4r4CTEr5!";
$lang['homepageurlmustincludeschema'] = "hom3P4G3 url mu\$+ INcLUd3 h+tp:// scH3m4.";
$lang['pictureurlmustincludeschema'] = "p1CTUr3 uRL mu\$T iNCLuD3 Ht+p:// sch3m@.";
$lang['avatarurlmustincludeschema'] = "aV4t@r Url MUst InClud3 ht+p:// \$CHEm4.";
$lang['postpage'] = "pOS+ P@ge";
$lang['nohtmltoolbar'] = "n0 h+ml To0LbAR";
$lang['displaysimpletoolbar'] = "dI\$pL@y \$ImpLE hTML +00L8@r";
$lang['displaytinymcetoolbar'] = "di\$pL@y WY\$1wyg HTml TO0lb@r";
$lang['displayemoticonspanel'] = "d1\$pL4y em0tiC0ns p@nel";
$lang['displaysignature'] = "d1Spl@y S1GNa+uR3";
$lang['disableemoticonsinpostsbydefault'] = "dIS48le 3m0+1c0n\$ 1n mes\$493\$ 8Y d3ph@ul+";
$lang['automaticallyparseurlsbydefault'] = "aUtOm@tiC4lLY p4r\$e urL\$ in M3\$S49e\$ by deph4ulT";
$lang['postinplaintextbydefault'] = "posT 1n pL@1N texT by d3ph@ul+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0\$t 1N hTml W1tH 4UTO-l1N3-8r34K\$ By def4uLT";
$lang['postinhtmlbydefault'] = "p05t In hTML BY dEph4UL+";
$lang['postdefaultquick'] = "usE qUIcK R3PLy 8y def4ULT. (PHull r3pLy in menu)";
$lang['threadlinksgotolastpage'] = "tHr3@d l1st l4\$t po5t LInk 9oeS +0 l4S+ PaGe 0pH PO\$+S.";
$lang['privatemessageoptions'] = "pR1v4+e me\$S4ge 0pti0NS";
$lang['privatemessageexportoptions'] = "pR1v4+e M3Ss4g3 3xpOr+ op+10ns";
$lang['savepminsentitems'] = "s4v3 A c0PY 0f 34Ch pm I \$3ND IN my 5En+ 1t3MS f0LDer";
$lang['includepminreply'] = "iNcLudE mESs@ge 80DY wHen REpLY1NG +0 pM";
$lang['autoprunemypmfoldersevery'] = "aUt0 prun3 my pm ph0ld3Rs 3V3RY:";
$lang['friendsonly'] = "fR1ends OnlY?";
$lang['youmustenteryourcurrentpasswd'] = "j00 mu\$t eN+3r Y0ur cuRR3nt P@s\$word";
$lang['youmustenteranewpasswd'] = "j00 MU\$T 3n+ER 4 N3W p@S\$word";
$lang['youmustconfirmyournewpasswd'] = "j00 MU\$+ confIRm yOUr n3w p@SsW0RD";
$lang['profileentriesmustnotincludehtml'] = "pr0F1l3 3ntRI3\$ muSt no+ 1ncLude h+ml";
$lang['failedtoupdateuserprofile'] = "f41LeD to upda+e u\$Er PRof1l3";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 Mu\$t prov1dE soME @N\$WeR 9roUPS";
$lang['mustprovidepolltype'] = "j00 Mus+ ProV1dE a POll +Yp3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 MUs+ PROV1de r3SUl+S disPL@y +yP3";
$lang['mustprovidepollvotetype'] = "j00 MuST pr0v1dE @ p0Ll vO+3 +ype";
$lang['mustprovidepollguestvotetype'] = "j00 MUSt SP3c1PHy 1pH gu35T\$ \$hoULd B3 alLOweD t0 VO+E";
$lang['mustprovidepolloptiontype'] = "j00 Mu\$T Prov1De 4 poLL Opti0n +Yp3";
$lang['mustprovidepollchangevotetype'] = "j00 MUS+ prov1DE 4 P0ll ch4NGe vO+3 +ype";
$lang['pollquestioncontainsinvalidhtml'] = "oNE OR m0re of youR poll qU3StI0ns Con+AINS INV@l1D HtmL.";
$lang['pleaseselectfolder'] = "pl34sE \$El3c+ 4 ph0lDer";
$lang['mustspecifyvalues1and2'] = "j00 muSt sPec1phy V@lUes f0R an5w3r\$ 1 4ND 2";
$lang['tablepollmusthave2groups'] = "t48ul4r phORm@t p0LLs Mus+ H4v3 preC1seLY tw0 vo+1N9 Gr0Ups";
$lang['nomultivotetabulars'] = "t4bul@r FORM4T p0lls c@NN0+ 8E Mul+i-vo+3";
$lang['nomultivotepublic'] = "pU8LIC b@Llot\$ c4NN0+ b3 MUl+i-v0+e";
$lang['abletochangevote'] = "j00 will 8e @8Le +O ch4nge your V0+e.";
$lang['abletovotemultiple'] = "j00 will 83 48lE +0 V0TE mULT1Pl3 +1M3\$.";
$lang['notabletochangevote'] = "j00 W1ll N0T b3 48L3 TO ch@n93 Y0ur V0+E.";
$lang['pollvotesrandom'] = "n0+3: P0LL v0teS 4re R@ndOMly 93N3R4+3d ph0r pr3VIeW 0Nly.";
$lang['pollquestion'] = "poLL qUEs+1oN";
$lang['possibleanswers'] = "pOs518l3 4nsW3R5";
$lang['enterpollquestionexp'] = "en+Er th3 @n\$W3r\$ ph0R YoUR poll qu3\$Ti0n.. iph YOuR Poll 1s @ &quot;y3\$/n0&quot; qu3\$+1ON, \$iMPly ent3r &quot;ye\$&quot; ph0R 4N\$Wer 1 @Nd &quot;N0&quot; ph0r aN5W3r 2.";
$lang['numberanswers'] = "n0. @Nsw3R\$";
$lang['answerscontainHTML'] = "anSW3r\$ COn+4in hTMl (noT inCLUDing 51gn4+Ure)";
$lang['optionsdisplay'] = "anSw3r\$ dispLAy tYPe";
$lang['optionsdisplayexp'] = "hOw \$h0Uld +h3 4Nsw3rs B3 prE\$EN+ED?";
$lang['dropdown'] = "a5 drOp-dowN l15+(s)";
$lang['radios'] = "as 4 SEries 0PH r@d1o 8u++0NS";
$lang['votechanging'] = "vO+3 Ch@N9IN9";
$lang['votechangingexp'] = "c4N @ p3RSOn Ch@n93 h1S 0r Her vote?";
$lang['guestvoting'] = "gu3ST vOt1N9";
$lang['guestvotingexp'] = "caN gu3\$+s Vot3 IN +HIs p0ll?";
$lang['allowmultiplevotes'] = "alLOW mul+1pl3 Vote\$";
$lang['pollresults'] = "p0LL R3\$UL+S";
$lang['pollresultsexp'] = "h0W w0uld j00 lIK3 to d1sPL@Y +h3 r3Sult\$ opH your p0ll?";
$lang['pollvotetype'] = "p0Ll v0+1N9 +ypE";
$lang['pollvotesexp'] = "h0W SH0ULd +3H P0LL 8E conDuc+3D?";
$lang['pollvoteanon'] = "aNONymOUslY";
$lang['pollvotepub'] = "pUBlic b@LloT";
$lang['horizgraph'] = "hor1ZON+4L 9r@ph";
$lang['vertgraph'] = "veRtic4L 9raPH";
$lang['tablegraph'] = "t48uL@r forM4t";
$lang['polltypewarning'] = "<b>w@rn1NG</b>: +h15 i\$ a puBliC b4lloT. y0uR n@m3 W1ll B3 v1siBLe neX+ +0 teh 0ptI0n j00 V0+e f0r.";
$lang['expiration'] = "exP1r4TI0n";
$lang['showresultswhileopen'] = "dO j00 w4n+ to ShoW re5uLT\$ wh1l3 TH3 p0lL 1\$ open?";
$lang['whenlikepollclose'] = "wh3N w0ULd j00 l1ke y0UR pOLl +O 4Ut0M@+1C@Lly clo\$E?";
$lang['oneday'] = "one d@y";
$lang['threedays'] = "thR33 d4Ys";
$lang['sevendays'] = "s3veN days";
$lang['thirtydays'] = "tHIr+Y d4ys";
$lang['never'] = "n3V3R";
$lang['polladditionalmessage'] = "adDiTI0n4l Me\$S4ge (OPti0n4L)";
$lang['polladditionalmessageexp'] = "d0 j00 w4nt to 1nclUD3 4n adDit1on4l p0S+ @pHter +eH poLL?";
$lang['mustspecifypolltoview'] = "j00 Mus+ \$pEC1PhY 4 POlL TO View.";
$lang['pollconfirmclose'] = "arE j00 5ur3 J00 w4n+ +o CLoSE ThE FOLl0wIng pOll?";
$lang['endpoll'] = "end pOll";
$lang['nobodyvotedclosedpoll'] = "n0bODY V0T3d";
$lang['votedisplayopenpoll'] = "%s 4ND %s h4v3 V0TEd.";
$lang['votedisplayclosedpoll'] = "%s @Nd %s voTed.";
$lang['nousersvoted'] = "no U5ER\$";
$lang['oneuservoted'] = "1 U\$Er";
$lang['xusersvoted'] = "%s us3rS";
$lang['noguestsvoted'] = "n0 GUes+S";
$lang['oneguestvoted'] = "1 9u3st";
$lang['xguestsvoted'] = "%s 9ues+S";
$lang['pollhasended'] = "pOll HAs 3ndeD";
$lang['youvotedforpolloptionsondate'] = "j00 VO+ed FOR %s 0N %s";
$lang['thisisapoll'] = "th1S 1S 4 p0ll. ClICK +0 v1eW R3\$uL+s.";
$lang['editpoll'] = "eDi+ P0LL";
$lang['results'] = "re\$uL+S";
$lang['resultdetails'] = "r3\$uL+ d3+41ls";
$lang['changevote'] = "chang3 V0TE";
$lang['pollshavebeendisabled'] = "pOlLS H4ve b33n dI\$4bl3d 8y TH3 F0ruM 0wneR.";
$lang['answertext'] = "aN\$w3r text";
$lang['answergroup'] = "aN\$w3R 9ROup";
$lang['previewvotingform'] = "pr3view V0tin9 pH0RM";
$lang['viewbypolloption'] = "v13w 8y pOLl 0p+1on";
$lang['viewbyuser'] = "vi3W bY Us3r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "ed1+ PRopH1LE";
$lang['profileupdated'] = "pR0PH1l3 upda+eD.";
$lang['profilesnotsetup'] = "t3h F0RUm 0wnER h@S n0t \$e+ up proFileS.";
$lang['ignoreduser'] = "iGnOr3d user";
$lang['lastvisit'] = "l4St Vis1T";
$lang['userslocaltime'] = "us3R's L0c4l +1m3";
$lang['userstatus'] = "s+4+uS";
$lang['useractive'] = "oNLinE";
$lang['userinactive'] = "iN4c+1Ve / Offline";
$lang['totaltimeinforum'] = "tOt@L +im3";
$lang['longesttimeinforum'] = "lON93\$+ Se5s10N";
$lang['sendemail'] = "s3nD em@1L";
$lang['sendpm'] = "senD PM";
$lang['visithomepage'] = "v151+ HOMeP@g3";
$lang['age'] = "a9e";
$lang['aged'] = "a9ed";
$lang['birthday'] = "b1RtHd@y";
$lang['registered'] = "rE9is+eREd";
$lang['findpostsmadebyuser'] = "f1ND pO\$+s M@de 8y %s";
$lang['findpostsmadebyme'] = "f1ND p0sT\$ M4DE 8Y m3";
$lang['findthreadsstartedbyuser'] = "finD +hr3@ds sTaRT3D by %s";
$lang['findthreadsstartedbyme'] = "fInd +hr3@DS \$T4R+ed 8y me";
$lang['profilenotavailable'] = "pr0fIL3 n0+ @V41lAbL3.";
$lang['userprofileempty'] = "thIs uSEr ha5 not FIll3d 1n +H31r pr0f1le 0R i+ 1s 5E+ tO priV4+e.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sorRy, NEw uS3R rE9i5+ra+10Ns @Re n0t all0wEd r1gh+ n0w. Pl3@se cheCk b4Ck l4Ter.";
$lang['usernametooshort'] = "us3rN4me Mus+ B3 @ minimum 0f 2 ch@r@c+3RS l0n9";
$lang['usernametoolong'] = "us3RN4M3 mUS+ 83 4 m4ximum Of 15 ch@r@c+3R\$ Lon9";
$lang['usernamerequired'] = "a l0g0n n4me 1S r3quired";
$lang['passwdmustnotcontainHTML'] = "pASswORD MUs+ Not COnt41N hTMl +4gs";
$lang['passwdtooshort'] = "p@sSWOrd MUS+ 8E 4 M1N1MUM 0ph 6 Ch4R4ct3r\$ L0ng";
$lang['passwdrequired'] = "a p4Ssw0Rd 1s R3qu1reD";
$lang['confirmationpasswdrequired'] = "a cONF1Rm4T10N P4S\$word is rEQuireD";
$lang['nicknamerequired'] = "a N1CKn4M3 1S requiReD";
$lang['emailrequired'] = "aN 3m41L @DDr3s5 1s Requ1REd";
$lang['passwdsdonotmatch'] = "paSswoRdS d0 not m@tch";
$lang['usernamesameaspasswd'] = "us3rn4m3 @nd p4sSW0RD musT B3 D1pHfeR3Nt";
$lang['usernameexists'] = "s0rRY, 4 u\$Er w1th th4+ n@me @lrE4dY 3xistS";
$lang['successfullycreateduseraccount'] = "sUcc3S\$FuLLy cr3A+Ed user 4cC0UnT";
$lang['useraccountcreatedconfirmfailed'] = "yOuR User 4Cc0Un+ H@s 833n crE@ted 8U+ th3 R3QU1ReD c0NF1rm4T1on email w@5 N0t s3NT. PLE4SE Con+4C+ +h3 pHOrum 0Wn3r T0 ReCtiFY +his. IN this M3@N+IM3 Ple@\$e click t3h c0ntinU3 buTTON +0 log1N.";
$lang['useraccountcreatedconfirmsuccess'] = "y0UR u\$eR 4Cc0unt ha\$ 8een created Bu+ bephor3 j00 c4n \$tAR+ P0\$+1nG J00 mUS+ cONfirm YOur 3M@1l @DdR3\$s. Pl3@sE cH3ck YOur 3maiL ph0r @ l1nk +H4t WILl @LL0W j00 t0 C0npHIrm Y0ur 4dDR3\$S.";
$lang['useraccountcreated'] = "yOur u5er 4Cc0uNT H4\$ B3en cr3@t3d 5uCcE\$spHuLLy! cLICK +eH c0n+inu3 bUT+0N 8eloW +O l0g1n";
$lang['errorcreatinguserrecord'] = "eRr0r CR34+1N9 UsEr REc0RD";
$lang['userregistration'] = "usEr r3g1STr4+1on";
$lang['registrationinformationrequired'] = "rEgis+r4tI0n InfORma+10N (requ1reD)";
$lang['profileinformationoptional'] = "pR0Ph1le 1nPH0rm4+Ion (Op+ION4l)";
$lang['preferencesoptional'] = "pReph3R3NCes (0ptIOn4l)";
$lang['register'] = "rEg1S+3r";
$lang['rememberpasswd'] = "rEm3M83r p4\$sWORd";
$lang['birthdayrequired'] = "d@te 0f 8IrTH 1s REquireD 0r iS 1nv4l1D";
$lang['alwaysnotifymeofrepliestome'] = "n0TIPHy ON r3PLY +0 m3";
$lang['notifyonnewprivatemessage'] = "n0+1Fy 0n N3w pRIv4te MesS@GE";
$lang['popuponnewprivatemessage'] = "poP up ON neW privA+3 M3\$s4GE";
$lang['automatichighinterestonpost'] = "aUT0m4+iC H1gh interEst 0n pO\$t";
$lang['confirmpassword'] = "c0nF1rm p@\$\$W0RD";
$lang['invalidemailaddressformat'] = "inV4l1d em4iL @dDre\$s PH0rmA+";
$lang['moreoptionsavailable'] = "m0Re pROfile @nD PR3pher3nCe opti0ns @r3 @vail48L3 0nCe j00 rEgIs+3R";
$lang['textcaptchaconfirmation'] = "c0Nph1rm4+ion";
$lang['textcaptchaexplain'] = "to pr3V3NT @u+0m@tED ReGIs+R4T1ONs +h1s ForuM r3Qu1RE5 j00 3nter 4 ConF1RM4+10N C0d3. t3h C0dE 1s d15Pl@Yed 1N +hE 1mAGe t0 TH3 RiGH+. 1f J00 4r3 v1SUally 1mp41R3D 0R canNO+ otH3rwI5E re4d +H3 Code pLE4SE c0n+ac+ +hE %s.";
$lang['textcaptchaimgtip'] = "tH1S IS @ c4p+cHA-PICturE. 1T Is u\$eD +o pr3V3nt @utOM4t1C r3g1\$Tr@tiOn";
$lang['textcaptchamissingkey'] = "a cOnphiRM4+ion code is r3Qu1r3D.";
$lang['textcaptchaverificationfailed'] = "teX+-C@P+CH4 V3rIF1c4ti0n Cod3 w4s 1nc0rr3c+. pl3@s3 R3-3nT3R it.";
$lang['forumrules'] = "f0RuM Rules";
$lang['forumrulesnotification'] = "in 0rdER +0 prOc33D, j00 mus+ @GR3E w1TH th3 follow1ng rules";
$lang['forumrulescheckbox'] = "i h4ve ReAD, And @9RE3 +o 48Id3 By th3 FORum ruL3\$.";
$lang['youmustagreetotheforumrules'] = "j00 muST @gr33 +o teh F0ruM rule\$ bEphoR3 j00 c4N Con+Inu3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "meMBer";
$lang['searchforusernotinlist'] = "s3ArCH ph0r 4 u\$er nOT iN list";
$lang['yoursearchdidnotreturnanymatches'] = "yOuR S34rCH d1D n0+ r3+uRN 4Ny ma+CHEs. TRy \$ImPLiFyin9 y0UR s34rch p4r4m3t3rs 4ND +ry 4g41N.";
$lang['hiderowswithemptyornullvalues'] = "hId3 roWs W1th emp+Y or NuLl V@lu35 1N seleC+eD cOLumnS";
$lang['showregisteredusersonly'] = "sh0w R3GiS+er3D USers oNLy (H1d3 9Ue\$Ts)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "reL4+10NSH1Ps";
$lang['userrelationship'] = "uSEr ReL4+IonSHip";
$lang['userrelationships'] = "uS3r rel4+1onShips";
$lang['failedtoremoveselectedrelationships'] = "faIl3D T0 R3Mov3 seL3c+eD rel@T1oNSHIp";
$lang['friends'] = "fr1endS";
$lang['ignoredcompletely'] = "iGnoR3d compl3+3ly";
$lang['relationship'] = "rel4T10n5hip";
$lang['restorenickname'] = "rEStoRe USeR's NiCknAM3";
$lang['friend_exp'] = "useR'S p0st\$ marK3d w1th 4 &quot;phri3Nd&quot; icOn.";
$lang['normal_exp'] = "useR'5 p0sT\$ 4Ppe4r @s NOrmal.";
$lang['ignore_exp'] = "us3r'\$ P0S+s 4R3 H1dDen.";
$lang['ignore_completely_exp'] = "tHre4D\$ 4ND POSt5 +0 Or Fr0m uS3r W1lL 4PP34r d3L3+3d.";
$lang['display'] = "d1\$pl@y";
$lang['displaysig_exp'] = "u5ER'\$ SigN4tur3 i\$ dI\$Pl@Yed ON THe1R p0stS.";
$lang['hidesig_exp'] = "uSER's siGN4tur3 1s hidDen ON +h31R pO5T\$.";
$lang['youcannotchangeuserrelationshipforownaccount'] = "j00 C4nn0+ ch@N9e US3r R3L@+iONsh1p phOR your owN u5Er @CCoun+";
$lang['cannotignoremod'] = "j00 c4nn0+ 19N0r3 thi\$ U\$eR, a\$ THEy @RE @ m0D3r4tor.";
$lang['previewsignature'] = "pr3VIEw S1Gn4+Ur3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "sE4RCh resuL+s";
$lang['usernamenotfound'] = "th3 Usern4me j00 sp3C1phied IN th3 to Or fr0M Phi3ld wa\$ not fOUnd.";
$lang['notexttosearchfor'] = "oNE or @lL 0PH y0ur 534rch KeywordS wEr3 1NV@lID. sE4rcH keYWords mus+ 83 N0 shoRT3r th4n %d Ch4r4CTerS, n0 LONgEr +h4n %d ChARAc+ER\$ aNd Must No+ ApPe4R 1N +H3 %s";
$lang['keywordscontainingerrors'] = "keYw0rD5 c0NT4iniNG Err0rs: %s";
$lang['mysqlstopwordlist'] = "my\$Ql s+opWOrd lISt";
$lang['foundzeromatches'] = "f0uNd: 0 Ma+cheS";
$lang['found'] = "fouNd";
$lang['matches'] = "m@+ch3\$";
$lang['prevpage'] = "pRev1ous p@9E";
$lang['findmore'] = "fiND M0r3";
$lang['searchmessages'] = "se4rch me\$S4g35";
$lang['searchdiscussions'] = "sE@rch D1\$CUssI0N5";
$lang['find'] = "fInd";
$lang['additionalcriteria'] = "add1ti0nal cr1teRI4";
$lang['searchbyuser'] = "s3@RCH bY us3r (op+i0n4l)";
$lang['folderbrackets_s'] = "f0ld3r(\$)";
$lang['postedfrom'] = "pOsT3d fRom";
$lang['postedto'] = "pO\$T3d TO";
$lang['today'] = "t0d4Y";
$lang['yesterday'] = "y3sT3RD4Y";
$lang['daybeforeyesterday'] = "d@Y b3F0RE yE\$t3RD@y";
$lang['weekago'] = "%s we3K 4go";
$lang['weeksago'] = "%s W33Ks 4G0";
$lang['monthago'] = "%s m0Nth @go";
$lang['monthsago'] = "%s M0n+HS @9o";
$lang['yearago'] = "%s y3@r @gO";
$lang['beginningoftime'] = "b3GInnINg 0ph +im3";
$lang['now'] = "now";
$lang['lastpostdate'] = "l4St pOs+ d@te";
$lang['numberofreplies'] = "nuM8eR of R3PL1E\$";
$lang['foldername'] = "fOLdEr N4me";
$lang['authorname'] = "aU+Hor n@M3";
$lang['relevancy'] = "reL3v4Ncy";
$lang['decendingorder'] = "n3W3\$t f1r5T";
$lang['ascendingorder'] = "oLD35t PH1rsT";
$lang['keywords'] = "keyWorDs";
$lang['sortby'] = "s0rT 8Y";
$lang['sortdir'] = "s0r+ D1r";
$lang['sortresults'] = "soRt R3suLTS";
$lang['groupbythread'] = "gR0Up 8y +Hr3Ad";
$lang['postsfromuser'] = "p0s+S PHrom uS3r";
$lang['threadsstartedbyuser'] = "thR3@dS s+Arted by u\$eR";
$lang['searchfrequencyerror'] = "j00 c@N oNLy se4rCh ONCE 3VeRY %s SecONd\$. ple@5e tRY 4941N l@+3R.";
$lang['searchsuccessfullycompleted'] = "se4RcH 5ucc35spHUlLy C0mpl3+eD. %s";
$lang['clickheretoviewresults'] = "cL1Ck h3r3 +o V13W rESUlt\$.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3L3c+";
$lang['searchforthread'] = "s34RcH for Thr3ad";
$lang['mustspecifytypeofsearch'] = "j00 Mu5+ Sp3cIFY tYPE of \$34Rch +0 perphORm";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "receNT +hr3@ds";
$lang['startreading'] = "s+@RT RE4dIn9";
$lang['threadoptions'] = "tHre4d 0Pti0nS";
$lang['editthreadoptions'] = "ed1T ThRE@d oP+ioNS";
$lang['morevisitors'] = "mOr3 VIs1tOrS";
$lang['forthcomingbirthdays'] = "f0rthcom1ng B1rthd@y5";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c@n edit +H1\$ Page frOM +3H 4DM1N int3rph4Ce";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w Discu\$S10n";
$lang['createpoll'] = "cr34+E PolL";
$lang['search'] = "se4rch";
$lang['searchagain'] = "se4rch A941N";
$lang['alldiscussions'] = "all d1SCus\$10Ns";
$lang['unreaddiscussions'] = "unr3AD D1ScUssI0NS";
$lang['unreadtome'] = "unre@d &quot;+o: M3&quot;";
$lang['todaysdiscussions'] = "tOd@Y'\$ DiSCu\$s1ons";
$lang['2daysback'] = "2 D4Y\$ 8@ck";
$lang['7daysback'] = "7 d4yS BAcK";
$lang['highinterest'] = "hI9H 1n+eR3\$+";
$lang['unreadhighinterest'] = "uNR3ad h19H 1nt3R35+";
$lang['iverecentlyseen'] = "i'V3 r3c3n+ly se3N";
$lang['iveignored'] = "i'VE i9N0Red";
$lang['byignoredusers'] = "bY I9n0r3d useRs";
$lang['ivesubscribedto'] = "i'V3 suBscri8ED +o";
$lang['startedbyfriend'] = "s+@r+3D bY fRI3nD";
$lang['unreadstartedbyfriend'] = "unr3@d 5tarT3D bY PHR1end";
$lang['startedbyme'] = "sTAR+ed 8Y m3";
$lang['unreadtoday'] = "unRead TOd@y";
$lang['deletedthreads'] = "d3Le+Ed tHRe4D\$";
$lang['goexcmark'] = "go!";
$lang['folderinterest'] = "f0lder 1N+er3\$t";
$lang['postnew'] = "pos+ N3W";
$lang['currentthread'] = "curR3N+ +hr3ad";
$lang['highinterest'] = "hIgH 1ntER3sT";
$lang['markasread'] = "maRk @S re4d";
$lang['next50discussions'] = "nEx+ 50 diScU\$s10NS";
$lang['visiblediscussions'] = "v1S18LE diScUs51Ons";
$lang['selectedfolder'] = "sEL3C+ed pHOLd3r";
$lang['navigate'] = "n4V1g4TE";
$lang['couldnotretrievefolderinformation'] = "tHEr3 4re no PH0lDER\$ AV@1L4bL3.";
$lang['nomessagesinthiscategory'] = "no mEs\$493\$ 1n tHIS C@Te9ory. Pl34se sElEcT 4NOth3R, oR %s ph0r 4ll +HR3@Ds";
$lang['clickhere'] = "clICk HEre";
$lang['prev50threads'] = "pR3viOus 50 +hREad5";
$lang['next50threads'] = "n3X+ 50 tHR3@ds";
$lang['nextxthreads'] = "nex+ %s +hr3@d\$";
$lang['threadstartedbytooltip'] = "tHr3@d #%s S+4r+3D by %s. V13wed %s";
$lang['threadviewedonetime'] = "1 +1m3";
$lang['threadviewedtimes'] = "%d +im3\$";
$lang['readthread'] = "reAd thre4d";
$lang['unreadmessages'] = "uNre@D m35\$493\$";
$lang['subscribed'] = "sU8ScR18Ed";
$lang['stickythreads'] = "s+iCKy thread\$";
$lang['mostunreadposts'] = "m0S+ uNRe4D pOst\$";
$lang['onenew'] = "%d nEW";
$lang['manynew'] = "%d n3w";
$lang['onenewoflength'] = "%d neW OF %d";
$lang['manynewoflength'] = "%d n3w OF %d";
$lang['confirmmarkasread'] = "aRE j00 sURe J00 w@Nt +o m4RK +h3 sel3Ct3D Thre4ds A\$ r3@D?";
$lang['successfullymarkreadselectedthreads'] = "successPHullY m@rk3D SElec+Ed +hr3Ad\$ a\$ r34D";
$lang['failedtomarkselectedthreadsasread'] = "f41L3d To m4rK sel3Cted thr3@d\$ 4S re4D";
$lang['gotofirstpostinthread'] = "gO +O f1R\$T pOSt IN thRE4d";
$lang['gotolastpostinthread'] = "g0 T0 la\$t P0ST in thr3@d";
$lang['viewmessagesinthisfolderonly'] = "vi3w M3S5493s iN +H1s ph0lDeR 0NLY";
$lang['shownext50threads'] = "sH0w N3xt 50 +Hr3Ads";
$lang['showprev50threads'] = "sHOw PR3VI0US 50 thRE4dS";
$lang['createnewdiscussioninthisfolder'] = "cR3@T3 nEw Discus510n in +h1s PH0ldeR";
$lang['nomessages'] = "no me\$s4GE\$";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0LD";
$lang['italic'] = "iTAL1c";
$lang['underline'] = "undeRL1ne";
$lang['strikethrough'] = "s+riK3+Hr0uGH";
$lang['superscript'] = "supEr\$CripT";
$lang['subscript'] = "su8script";
$lang['leftalign'] = "l3fT-@LIGn";
$lang['center'] = "cEnT3R";
$lang['rightalign'] = "r1Gh+-aligN";
$lang['numberedlist'] = "nuMBer3d list";
$lang['list'] = "li\$t";
$lang['indenttext'] = "iNden+ t3xt";
$lang['code'] = "cODe";
$lang['quote'] = "qu0t3";
$lang['unquote'] = "uNqUO+E";
$lang['spoiler'] = "sp01l3r";
$lang['horizontalrule'] = "h0rIZ0n+4l rule";
$lang['image'] = "im4GE";
$lang['hyperlink'] = "hyP3RLInK";
$lang['noemoticons'] = "d1s48Le 3m0+1C0ns";
$lang['fontface'] = "fON+ f4c3";
$lang['size'] = "s1z3";
$lang['colour'] = "col0uR";
$lang['red'] = "red";
$lang['orange'] = "oraN9e";
$lang['yellow'] = "yElLOW";
$lang['green'] = "gRe3N";
$lang['blue'] = "blU3";
$lang['indigo'] = "iNd19O";
$lang['violet'] = "vIoLEt";
$lang['white'] = "whI+3";
$lang['black'] = "bl4CK";
$lang['grey'] = "gReY";
$lang['pink'] = "p1nk";
$lang['lightgreen'] = "lIGHt 9r3eN";
$lang['lightblue'] = "li9ht 8luE";

// Forum Stats --------------------------------

$lang['forumstats'] = "fORUm \$t4+S";
$lang['userstats'] = "u5eR sT@T5";

$lang['usersactiveinthepasttimeperiod'] = "%s @C+1v3 iN +H3 p4sT %s.";

$lang['numactiveguests'] = "<b>%s</b> 9UE\$t\$";
$lang['oneactiveguest'] = "<b>1</b> 9UES+";
$lang['numactivemembers'] = "<b>%s</b> mEM8er5";
$lang['oneactivemember'] = "<b>1</b> mEMb3r";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4NonYM0U5 mEMB3rS";
$lang['oneactiveanonymousmember'] = "<b>1</b> @NONym0u\$ m3mBER";

$lang['numthreadscreated'] = "<b>%s</b> +HRE4Ds";
$lang['onethreadcreated'] = "<b>1</b> tHR3aD";
$lang['numpostscreated'] = "<b>%s</b> pos+S";
$lang['onepostcreated'] = "<b>1</b> P0\$T";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1nvI518le)";
$lang['viewcompletelist'] = "vi3W coMPlEte L1S+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUR m3m83RS h4ve m4De 4 toT4L of %s @nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "loNGE\$t +hRE4D iS <b>%s</b> WIth %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tH3R3 H4vE 833N <b>%s</b> Pos+S m4d3 in Th3 L@s+ 60 minu+3\$.";
$lang['therehasbeenonepostmadeinthelastsixtyminutes'] = "theR3 h4s b33n <b>1</b> P0sT M4de in +He L4\$+ 60 m1nu+eS.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "m0St p05T\$ 3V3r M@d3 1N 4 \$1NGl3 60 MinUTe pERi0D 1s <b>%s</b> 0n %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 H4v3 <b>%s</b> R391s+3Red memb3R\$ @nd TH3 new3S+ m3M8ER is <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "wE h4vE %s re9IST3r3d MEm83r\$.";
$lang['wehaveoneregisteredmember'] = "w3 H@v3 0Ne r39IsteRED m3m8Er.";
$lang['mostuserseveronlinewasnumondate'] = "m0s+ U5er5 Ev3R 0nl1n3 w45 <b>%s</b> 0N %s.";
$lang['statsdisplaychanged'] = "s+a+S DiSPl@Y ch4NGed";

$lang['viewtop20'] = "vIeW toP 20";

$lang['folderstats'] = "f0LdeR stats";
$lang['threadstats'] = "tHR3ad st4+s";
$lang['poststats'] = "p0\$t sT4+S";
$lang['pollstats'] = "pOlL s+4+5";
$lang['attachmentsstats'] = "a++4ChM3nts S+a+S";
$lang['userpreferencesstats'] = "u5eR pr3phER3NcES st@ts";
$lang['visitorstats'] = "viS1t0r s+4+S";
$lang['sessionstats'] = "s3S5ioN st4ts";
$lang['profilestats'] = "pROFILe ST4T\$";
$lang['signaturestats'] = "sIGN4Tur3 \$+4+\$";
$lang['ageandbirthdaystats'] = "a9E @nd 81R+hday sT@t\$";
$lang['relationshipstats'] = "rEL4+1oNSHIp S+4+s";
$lang['wordfilterstats'] = "w0rD Fil+3R s+4+S";

$lang['numberoffolders'] = "numb3r OF Ph0lD3RS";
$lang['folderwithmostthreads'] = "folDer W1+h M0\$+ tHRE4d\$";
$lang['folderwithmostposts'] = "foLDeR w1th m0\$t p0\$+s";
$lang['totalnumberofthreads'] = "t0T4L number of tHRe4D\$";
$lang['longestthread'] = "loNG3ST thr3@d";
$lang['mostreadthread'] = "mOSt re@d +hRE4D";
$lang['threadviews'] = "vI3ws";
$lang['averagethreadcountperfolder'] = "av3r4Ge tHR3@D c0unt per FOlDer";
$lang['totalnumberofthreadsubscriptions'] = "to+4l NumB3r of +Hr3@d 5uBscRip+ions";
$lang['mostpopularthreadbysubscription'] = "mO\$T P0Pul@r Thread 8y su8ScR1P+10N";
$lang['totalnumberofposts'] = "t0t@L numb3r of p0\$ts";
$lang['numberofpostsmadeinlastsixtyminutes'] = "nuMB3r 0f P05+S M@D3 IN L4s+ 60 M1nu+eS";
$lang['mostpostsmadeinasinglesixtyminuteperiod'] = "mO\$+ P0S+s m4D3 1N OnE 60 MInu+e p3ri0D";
$lang['averagepostsperuser'] = "aV3r4g3 p0sts per user";
$lang['topposter'] = "t0P p0\$+3r";
$lang['totalnumberofpolls'] = "toT4l nuMb3r OPH pOLls";
$lang['totalnumberofpolloptions'] = "to+4L NuMB3R 0ph P0LL Options";
$lang['averagevotesperpoll'] = "aV3r@9e VO+35 p3r pOLl";
$lang['totalnumberofpollvotes'] = "tOt@L Num8Er 0ph p0Ll V0+e5";
$lang['totalnumberofattachments'] = "tO+Al num8er 0PH A+t4Chments";
$lang['averagenumberofattachmentsperpost'] = "av3R4GE 4+t@chm3N+ c0UnT P3r POS+";
$lang['mostdownloadedattachment'] = "mO\$t dOWnL0@D3d 4++4cHM3N+";
$lang['mostusedforumstyle'] = "mO\$t uSED f0rum S+yl3";
$lang['mostusedlanguuagefile'] = "mOs+ u53D l4ngu493 fiLE";
$lang['mostusedtimezone'] = "moS+ u\$eD +1me zONe";
$lang['mostusedemoticonpack'] = "m05+ u\$ED 3MO+iCON p@ck";

$lang['numberofusers'] = "nuMB3r opH us3R\$";
$lang['newestuser'] = "neWE\$t uSeR";
$lang['numberofcontributingusers'] = "nUM8Er 0pH CoN+r18U+1ng Us3r\$";
$lang['numberofnoncontributingusers'] = "nUmB3R oF NON-C0n+ri8Uting u\$Er\$";
$lang['subscribers'] = "sUBScri83rs";

$lang['numberofvisitorstoday'] = "num83R Oph v1\$1TorS +od4y";
$lang['numberofvisitorsthisweek'] = "nuM83R Of vis1TORs +H1S w33K";
$lang['numberofvisitorsthismonth'] = "nuMB3r 0f VIsi+0rS th1s m0ntH";
$lang['numberofvisitorsthisyear'] = "nUMB3R 0PH viSI+orS +h1\$ y34r";

$lang['totalnumberofactiveusers'] = "tO+4L NUmB3r 0ph 4Ctiv3 us3r5";
$lang['numberofactiveregisteredusers'] = "nuM83R of 4ct1vE R39ist3rEd us3R\$";
$lang['numberofactiveguests'] = "num8ER 0f AC+1Ve gues+s";
$lang['mostuserseveronline'] = "mO\$t us3r\$ Ev3R onLIne";
$lang['mostactiveuser'] = "m0St @Ctiv3 user";
$lang['numberofuserswithprofile'] = "nUMb3r 0F u\$Er\$ W1TH prof1l3";
$lang['numberofuserswithoutprofile'] = "nUmb3R 0PH U\$Er5 with0Ut PRopH1LE";
$lang['numberofuserswithsignature'] = "nUm83r oph U\$3rs WITh \$ign@ture";
$lang['numberofuserswithoutsignature'] = "num83R of USeRS w1th0u+ SIgn4ture";
$lang['averageage'] = "av3R@9e 49E";
$lang['mostpopularbirthday'] = "m0s+ pOPulaR 81rtHd4Y";
$lang['nobirthdaydataavailable'] = "n0 8IrtHd@Y d4t4 4VaiL48Le";
$lang['numberofusersusingwordfilter'] = "nUm8er 0ph U\$3RS U\$1N9 w0Rd ph1l+er";
$lang['numberofuserreleationships'] = "nuM8Er 0F user rel@ti0NSH1P5";
$lang['averageage'] = "avEr@9E @9e";
$lang['averagerelationshipsperuser'] = "aVeR@g3 R3L4TI0NSh1pS pEr U\$3r";

$lang['numberofusersnotusingwordfilter'] = "nUm8er oF useR\$ nOT U51N9 wORd PHilt3r";
$lang['averagewordfilterentriesperuser'] = "av3r49E worD fiL+3R en+ries PeR uSEr";

$lang['mostuserseveronlinedetail'] = "%s On %s";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPD@t3\$ s4v3D SUCcEssFUlly";
$lang['useroptions'] = "uS3r opti0NS";
$lang['markedasread'] = "m4rK3d 4s R3ad";
$lang['postsoutof'] = "p0STS 0ut 0f";
$lang['interest'] = "iN+eres+";
$lang['closedforposting'] = "cL0SEd for Po\$tiN9";
$lang['locktitleandfolder'] = "lock t1+LE AND ph0ldEr";
$lang['deletepostsinthreadbyuser'] = "d3L3+E P0\$+s 1n thread By u\$Er";
$lang['deletethread'] = "d3LE+e +HrE4D";
$lang['permenantlydelete'] = "p3RM@n3n+LY Del3+e";
$lang['movetodeleteditems'] = "m0v3 To DeLet3d thrE4d\$";
$lang['undeletethread'] = "unDeL3+3 THre4D";
$lang['markasunread'] = "m4Rk @S UNr3Ad";
$lang['makethreadsticky'] = "m@KE +Hr3AD STIckY";
$lang['threareadstatusupdated'] = "tHr3@d re4D st4Tu\$ upd4TEd succE\$SPHuLlY";
$lang['interestupdated'] = "thR34d in+3res+ S+A+U\$ updatEd \$uCCe\$sfULLy";
$lang['threadwassuccessfullydeleted'] = "thre4d w4S suCc35SFullY D3L3T3D";
$lang['threadwassuccessfullyundeleted'] = "thRE@d W4S \$UcC3s5FUlly uNdEL3+ed";
$lang['failedtoupdatethreadreadstatus'] = "f41l3d to upd@te +hr3@D RE4d \$t4+Us";
$lang['failedtoupdatethreadinterest'] = "f41led to uPd@t3 thr34d iN+3ReS+";
$lang['failedtorenamethread'] = "f@1L3d t0 rEn@mE THre4D";
$lang['failedtomovethread'] = "f41L3D +o MOVe +HrE@D +0 sp3c1f1eD PHolDer";
$lang['failedtoupdatethreadstickystatus'] = "f41LEd +0 Upd@TE thr34D 5T1CkY S+@+U\$";
$lang['failedtoupdatethreadclosedstatus'] = "f@1LeD TO uPD4+e thREaD cL0S3D 5T4tu5";
$lang['failedtoupdatethreadlockstatus'] = "f41lED to upd@t3 +HR3@d loCK s+4tus";
$lang['failedtodeletepostsbyuser'] = "f4ILed +0 del3t3 POs+S 8y sel3C+ED uSer";
$lang['failedtodeletethread'] = "f4iL3D to del3te thre@d.";
$lang['failedtoundeletethread'] = "f41L3d TO un-Del3+e +HR3AD";

// Folder Options (folder_options.php) ---------------------------------

$lang['folderoptions'] = "fOLD3R 0P+I0n\$";
$lang['foldercouldnotbefound'] = "tH3 reque\$+3d ph0lDer c0Uld N0+ B3 fouNd 0R 4Cc35S w45 D3N13D.";
$lang['failedtoupdatefolderinterest'] = "f4il3D to UpdA+3 f0ld3R 1n+3rest";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dic+10n@ry";
$lang['spellcheck'] = "spEll ch3Ck";
$lang['notindictionary'] = "no+ 1N D1Ct1oN4RY";
$lang['changeto'] = "chAnge +0";
$lang['restartspellcheck'] = "r3s+4R+";
$lang['cancelchanges'] = "c4NC3l cH4NGe\$";
$lang['spellcheckcomplete'] = "speLL cheCk 1s C0mpL3+E. TO r3S+4rt \$pell ChEck CL1Ck Rest@rt 8ut+0n b3lOw.";
$lang['spellcheck'] = "spell Ch3cK";
$lang['noformobj'] = "no f0rM 0bjEC+ 5P3CIPh13d F0r rEturN teXT";
$lang['ignore'] = "iGn0re";
$lang['ignoreall'] = "iGnORe @ll";
$lang['change'] = "ch4NGe";
$lang['changeall'] = "cH4nge @ll";
$lang['add'] = "adD";
$lang['suggest'] = "su9G3s+";
$lang['nosuggestions'] = "(n0 suggESTI0Ns)";
$lang['cancel'] = "c4NC3L";
$lang['dictionarynotinstalled'] = "no Dic+iON@RY h@S B3eN 1n\$T4ll3D. Pl34S3 con+4c+ +hE foRUm 0wN3r to R3m3Dy Thi\$.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "pOSt r3Adin9 @lloweD";
$lang['postcreationallowed'] = "pOS+ cr3a+10n 4llOW3D";
$lang['threadcreationallowed'] = "thre4d Cr3@t1oN @ll0w3D";
$lang['posteditingallowed'] = "pO5T 3d1T1N9 @llOWeD";
$lang['postdeletionallowed'] = "po\$T D3l3+ioN 4llOWEd";
$lang['attachmentsallowed'] = "upLo@D1Ng 4++4chmen+s @lloW3d";
$lang['htmlpostingallowed'] = "htMl POSTIn9 4llOw3D";
$lang['usersignatureallowed'] = "u53r S1Gn4TUR3 4lL0W3d";
$lang['guestaccessallowed'] = "gU3s+ 4cce\$s All0wed";
$lang['postapprovalrequired'] = "p0\$T @PPr0V4l r3qu1r3D";

// RSS feeds gubbins

$lang['rssfeed'] = "rs\$ ph3ed";
$lang['every30mins'] = "eV3ry 30 minu+3\$";
$lang['onceanhour'] = "once @n HouR";
$lang['every6hours'] = "eV3rY 6 HOUrs";
$lang['every12hours'] = "eVERY 12 h0UR\$";
$lang['onceaday'] = "onCE @ D@y";
$lang['onceaweek'] = "onC3 4 w33K";
$lang['rssfeeds'] = "r5\$ PHeeD\$";
$lang['feedname'] = "fE3d N@m3";
$lang['feedfoldername'] = "f33d ph0lDer NAMe";
$lang['feedlocation'] = "fEEd L0c@t1On";
$lang['threadtitleprefix'] = "tHR34D TitLE preFiX";
$lang['feednameandlocation'] = "f33D n@m3 4nd L0C4t1ON";
$lang['feedsettings'] = "feed SEt+ings";
$lang['updatefrequency'] = "upd4+e fr3qu3ncY";
$lang['maxitemcount'] = "m4X It3m couNT";
$lang['maxitemcounthint'] = "m1N: 1, m@X: 10";
$lang['rssclicktoreadarticle'] = "cliCk here To reaD ThIS 4R+icl3";
$lang['addnewfeed'] = "aDD N3W ph3eD";
$lang['editfeed'] = "ed1T Ph3ED";
$lang['feeduseraccount'] = "f3ED uSeR 4cc0unt";
$lang['noexistingfeeds'] = "nO 3x1S+in9 Rss ph33d\$ ph0uNd. +0 4dd @ pH33D Cl1CK +h3 '4dD NeW' BUTt0n b3Low";
$lang['rssfeedhelp'] = "heR3 j00 c4n S3+UP sOmE Rss Fe3d\$ PH0R 4uTOm4t1C pr0p4g4Ti0N 1n+0 YOur ph0rum. +eH 1+ems PhROM tHE r5s PhEed\$ j00 4dD w1LL 83 cr3@t3d 45 +HR3@Ds Which Us3R\$ C4n R3ply +0 A\$ IF they W3r3 norM4L poS+\$. +h3 rSS Pheed Mu\$t B3 @cCE\$s18LE V14 HT+p 0r 1T w1lL n0+ wORK.";
$lang['mustspecifyrssfeedname'] = "muST \$pEcify r5S fe3D n4Me";
$lang['mustspecifyrssfeeduseraccount'] = "muS+ SpEc1Fy rSs FeEd USeR @cC0Unt";
$lang['mustspecifyrssfeedfolder'] = "mUS+ \$PeciFY rs\$ pheeD F0ld3r";
$lang['mustspecifyrssfeedurl'] = "mU\$t SP3CiFy Rss FEeD uRL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mu\$+ SPec1Fy RS\$ Fe3D Upd4+e fr3qu3nCY";
$lang['maxitemcountmustbebetween1and10'] = "m4x 1T3m cOUnt muS+ b3 b3+w3EN 1 @nd 10";
$lang['unknownrssuseraccount'] = "uNKN0wN RS\$ u\$eR 4cc0unt";
$lang['rssfeedsupportshttpurlsonly'] = "rs\$ f33D supP0Rt\$ h+TP UrLS onLY. 5EcuRE fE3D\$ (H+TPs://) @r3 nO+ sUPpoRT3d.";
$lang['rssfeedurlformatinvalid'] = "r5\$ f33D url f0rm4+ 1s 1nvalid. url MUst incLUd3 sch3M3 (e.g. http://) 4ND @ H0\$tN@M3 (3.G. wWW.h0s+N4ME.COM).";
$lang['rssfeeduserauthentication'] = "r\$\$ pH33d dO3\$ NOt \$uPP0rt H++p u\$eR 4UTH3NTic@tI0n";
$lang['successfullyremovedselectedfeeds'] = "succ3s\$FuLLy rem0ved SEl3Ct3D PhE3ds";
$lang['successfullyaddedfeed'] = "suCc3ssPHuLLY 4dD3D n3W pheed";
$lang['successfullyeditedfeed'] = "sUcCE\$\$fullY 3DI+ed F3ED";
$lang['failedtoremovefeeds'] = "f@il3d tO rEM0v3 SOm3 0r 4ll 0PH +eh 5EL3c+ed FEED\$";
$lang['failedtoaddnewrssfeed'] = "f41LED +0 @dd new R\$S Feed";
$lang['failedtoupdaterssfeed'] = "f41Led To UPd@te rSS pheEd";
$lang['rssstreamworkingcorrectly'] = "r5S Str3AM @PP3@R\$ +0 bE w0rk1N9 c0rrEctly";
$lang['rssstreamnotworkingcorrectly'] = "rs\$ S+re@m w4s 3MPty 0R cOuLD N0t B3 phOUnd";
$lang['invalidfeedidorfeednotfound'] = "invALid feeD 1D or ph33D nOT ph0und";

// PM Export Options

$lang['pmexportastype'] = "eXp0rt @S +YPE";
$lang['pmexporthtml'] = "htML";
$lang['pmexportxml'] = "xmL";
$lang['pmexportplaintext'] = "pL4in +Ext";
$lang['pmexportmessagesas'] = "exP0rt mE\$S4GES 45";
$lang['pmexportonefileforallmessages'] = "oN3 FIle PH0r ALl m3\$s4ge\$";
$lang['pmexportonefilepermessage'] = "oN3 PH1l3 P3R mE\$s4GE";
$lang['pmexportattachments'] = "eXp0r+ @++4ChMEn+s";
$lang['pmexportincludestyle'] = "inClude fORum S+Yl3 SHe3+";
$lang['pmexportwordfilter'] = "aPpLY wORd pH1l+3R +0 M3S5493S";
$lang['failedtoexportmessages'] = "faIL3d To exPOrt MeSs@Ge\$";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHr3@D H4S b3en \$Plit";
$lang['threadhasbeenmerged'] = "tHRE@d h4\$ 8e3N M3R93d";
$lang['mergesplitthread'] = "m3R9E / SPL1T thr34D";
$lang['mergewiththreadid'] = "m3rG3 W1th THr3@D id:";
$lang['postsinthisthreadatstart'] = "pOs+S iN thI\$ +hr34d a+ 5t4RT";
$lang['postsinthisthreadatend'] = "poS+S in th1s +hr3@d a+ End";
$lang['reorderpostsintodateorder'] = "rE-ORDer PosTS 1n+0 d4t3 ORd3R";
$lang['splitthreadatpost'] = "sPLIT +hR3@d @t P0st:";
$lang['selectedpostsandrepliesonly'] = "s3lected PO\$T @nD R3plie\$ onLY";
$lang['selectedandallfollowingposts'] = "s3Lec+ed 4nD @Ll foLlOwiN9 Pos+\$";

$lang['threadmovedhere'] = "h3RE";

$lang['thisthreadhasmoved'] = "<b>thrE4dS merg3d:</b> +hIS +HrE4d h@s M0veD %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHRe4DS M3rGED:</b> +H1S THr3@d W@\$ m3R93D phr0m %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thre@D 5pLI+:</b> \$OMe p0\$+\$ IN +h1s THr3@D h4VE BEen moveD %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHR34d 5plit:</b> soMe pOs+s 1n TH1\$ +hre4d were mov3d phrom %s";

$lang['thisposthasbeenmoved'] = "<b>tHR3@D SpliT:</b> +hI5 p0\$t H4s Been m0veD %s";

$lang['invalidfunctionarguments'] = "iNV4l1D PHuNC+10n ARguM3N+\$";
$lang['couldnotretrieveforumdata'] = "coUld n0T r3+R13v3 PHOrUm D4t4";
$lang['cannotmergepolls'] = "one 0r mor3 THR3@D\$ 1S @ pOll. j00 c4nnot m3R93 P0lL5";
$lang['couldnotretrievethreaddatamerge'] = "coUld nOT r3tRI3VE +HReaD D@t4 phrom 0n3 0R more +HR34ds";
$lang['couldnotretrievethreaddatasplit'] = "c0Uld NO+ r3+r13Ve threaD d4+4 FR0M sourCe +hR3@d";
$lang['couldnotretrievepostdatasplit'] = "c0uLd n0+ r3TR1eve pOSt d4t4 phr0M \$ourC3 Thre@D";
$lang['failedtocreatenewthreadformerge'] = "f@Iled to CrE4t3 NeW +hr3@D f0R M3Rg3";
$lang['failedtocreatenewthreadforsplit'] = "f41LED TO cREa+3 N3W tHR3@d ph0r \$pl1+";
$lang['nopermissiontomergethreads'] = "j00 4Re n0t P3RMit+3d TO mER9e teh sel3C+ed +hr3@ds";
$lang['failedtoexecutethreadmergequery'] = "f41L3d TO EX3CU+e thre@d m3rgE query";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHRE@d \$UB\$cR1p+i0n5";
$lang['couldnotupdateinterestonthread'] = "coULD n0+ uPD@t3 INt3r3\$T 0n +hREAD '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHr34d int3ReSTs UpDa+eD SuCc3ssfULlY";
$lang['nothreadsubscriptions'] = "j00 aR3 Not \$Ub\$cr18ed +o 4ny +hre@d\$.";
$lang['nothreadsignored'] = "j00 4r3 not 19NOr1NG 4Ny THrEAd\$.";
$lang['nothreadsonhighinterest'] = "j00 h4ve n0 higH InT3rES+ threaD\$.";
$lang['resetselected'] = "rE\$E+ SEleC+ed";
$lang['ignoredthreads'] = "i9NoRED THr34ds";
$lang['highinterestthreads'] = "h1Gh Inter35+ thre4ds";
$lang['subscribedthreads'] = "su8sCRi8eD +hre@d\$";
$lang['currentinterest'] = "cuRreN+ 1n+eres+";

// Folder subscriptions

$lang['foldersubscriptions'] = "folDEr Su8\$Cr1Pt10NS";
$lang['couldnotupdateinterestonfolder'] = "could nOT upd4+E In+3re\$T 0n FoLd3r '%s'";
$lang['folderinterestsupdatedsuccessfully'] = "f0Ld3R IN+3rES+s Upd4t3D succEs\$fullY";
$lang['nofoldersubscriptions'] = "j00 4re No+ su8\$Cr1BeD to 4NY fold3R5.";
$lang['nofoldersignored'] = "j00 @re NO+ igNOr1ng 4nY f0Ld3r5.";
$lang['resetselected'] = "r353+ \$EL3c+ed";
$lang['ignoredfolders'] = "i9nOReD fOlders";
$lang['subscribedfolders'] = "subSCri83D pHOLd3r\$";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c4n OnLY aDd 3 C0lumn5. +0 4dd @ n3W coluMN Clo\$e 4n 3xiStiN9 ON3";
$lang['columnalreadyadded'] = "j00 hAVe aLRe4DY @dd3d +H1S c0lumn. 1f j00 W4nt +0 r3M0ve 1+ CL1cK IT\$ cloSE 8utt0n";

?>