<?php
$error = "";        // hibakezelés
$msg = ""; 

require_once("dbconnect.php");
session_start(); 

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Házirend</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="main.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
</head>
<body>
    


    <?php require_once("header.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once("sidebar_menu.php"); ?>

            <!-- Main Content -->
            <main role="main" class="ml-sm-auto col-lg-10 px-md-4">
                <!--itt kell tartalommal feltölteni az oldalt -->
                <div class="container mt-3">
                <h1>Házirend</h1><br><br>
<p class="epi_p">
A vásárokról és piacokról szóló 55/2009.(III.13.) Korm. rendelet 6.§ (1) bekezdése értelmében a Vásár házirendjét az üzemeltető az alábbiak szerint állapítja meg:
<br><br>
1. A zavartalan működés és a későbbi sikerek érdekében a házirendben foglalt szabályok betartása a piacon jelen lévő valamennyi természetes és jogi személyre, illetve jogi személyiséggel nem rendelkező szervezetre kötelező érvénnyel kiterjed.
<br>
2. A piacon való részvétel minden esetben előzetes egyeztetést igényel.
<br>
3. A piaci helyfoglalás első lépése – amennyiben az árus korábban nem vett részt egyetlen Vásáron sem – az online,  címen elérhető Jelentkezési Lap kitöltése.
<br>
4. A bekerülés nem jelentkezési sorrendben történik. Az üzemeltetőnek joga van belátása szerint mérlegelni és dönteni a részvételi lehetőségről és joga van indoklás nélkül elutasítani a jelentkezést, amennyiben a piac érdekeit szem előtt tartva indokoltnak látja azt.
<br>
Advertisement

Privacy Settings
5. Az üzemeltető az árus Jelentkezési Lapon megadott személyes adatait (ideértve a személyes elérhetőségeket és a számlázási adatokat) kizárólag kapcsolattartás és a zökkenőmentes és hatályos törvényeknek megfelelő üzleti tevékenység folytatása céljából őrzi határozott ideig a jogszabályoknak megfelelően. Harmadik személynek azt semmilyen célból nem adja ki.
<br>
6. A piacon csak az üzemeltető által kijelölt helyen, az általa kiadott napijegy vagy bérleti szerződés alapján szabad árusítani. A napijegy másra nem ruházható át. A kijelölt piachelyek és bérlemények elfoglalása a piac napján, az üzemeltető által előre meghatározott rend szerint történik. A bérlő tudomásul veszi, hogy az üzemeltető a helyszín aktuális adottságainak megfelelően, a legjobb tudása szerint alakítja ki az árusítóhelyeket, a külső körülményekből (pl. időszakos kiállítás, egyéb a piaccal egybeeső rendezvény) adódó esetleges kellemetlenségekért felelősséget vállalni nem tud, de lehetőségeihez mérten mindent megtesz a zökkenőmentes lebonyolításért.
<br>
7. Az üzemeltető nem köteles ugyanazt a helyet vagy asztalt több piaci napon át ugyanazon helyhasználó részére biztosítani.
<br>
8. A helyhasználók a számukra kijelölt terület vagy asztal használatára a piac nyitásától a zárásáig tartó időtartamban jogosultak.
<br>
9. A piacon kizárólag az üzemeltetővel előre egyeztetett termékek árusíthatók.
<br>
10. Az üzemeltető vagy képviselője ellenőrizheti a piacra bevitt és ott forgalmazott áruk minőségét, osztályba sorolását, valamint valamennyi, a kereskedés rendjét szabályozó jogszabályi előírás betartását és amennyiben problémát, hiányosságot észlel, a piac érdekeit szem előtt tartva azonnali hatállyal kötelezheti a bérlőt a távozásra.
<br>
11. Aki a piacon értékesít és nincs érvényes napijegye vagy bérleti szerződése (avagy azt az üzemeltető képviselőjének felszólításra nem mutatja fel), azonnal köteles elhagyni a piac területét.
<br>
12. A napi helyhasználat díját – amennyiben az üzemeltető és a bérlő között nincs érvényben más megállapodás – legkésőbb az árusítás napjáig kell megfizetni a meghatározott díjszabás szerint, készpénzben vagy utalással. Az üzemeltető a helypénz megfizetésekor azzal egyező értékű napijegyet vagy nyugtát/számlát ad át a helyhasználónak. A bérleti díj kifizetése után annak visszafizetésére az üzemeltetőnek nincs lehetősége.
<br>
13. A bérlő a bérleményt csak rendeltetésének megfelelően használhatja. Ennek megszegése esetén, illetve ha az üzemeltető, vagy annak megbízottja felszólítása ellenére a bérlő tovább folytatja jogellenes tevékenységét, akkor a bérleti jog megvonásra kerül.
<br>
14. A bérlő által használt piaci létesítmény, berendezés megváltoztatásához az üzemeltető előzetes hozzájárulását kell kérni. A helyhasználó az eredeti állapotot köteles visszaállítani.
<br>
15. Az árusítóhelyek környékét, a közlekedési utakat, folyosókat, különös tekintettel a Vásár hivatalos kiürítési tervében szereplő útvonalakra áruval, használaton kívüli göngyöleggel és egyéb eszközökkel elfoglalni tilos.
<br>
16. Az eladók kötelesek az árusítás befejezése után az általuk elfoglalt területet az esetleges szennyeződésektől megtisztítani és az összegyűjtött hulladék elszállításáról gondoskodni. Az átvett berendezéseket és eszközöket az üzemeltetőnek átadni. Ha az eladó az általa elfoglalt helyet bizonyíthatóan nem hagyja tisztán, a piac üzemeltetője 20000 Ft bírságot számolhat fel, vagy kizárhatja az árust a következő árusítási lehetőségekből.
<br>
17. Nagybani (viszonteladók részére történő) árusítás a piac területén nem folytatható.
<br>
18. Az árusítóhelyeken csak hatóságilag hitelesített és hibátlan mérőeszköz használható. Az áru mérését úgy kell elvégezni, hogy annak helyességét a vásárló ellenőrizni tudja. Az üzemeltető a vásárló külön kérésére, a piac területén elhelyezett hitelesített mérleggel lehetőséget biztosít a megvásárolt áru súlyának ellenőrzésére.
<br>
19. A szakhatósági vizsgálatot igénylő áru (vágott állat, baromfi, tej, tejtermék, mák, őrölt paprika, méz, stb.) kizárólag szakhatóság által kiállított érvényes engedély birtokában árusítható. Tőkehús, élő állat, alkohol tartalmú szeszesital, üdítőital és meleg- és/vagy helyben fogyasztható étel a Vásáron nem vagy csak az üzemeltető kifejezett hozzájárulásával árusítható.
<br>
20. Az üzemeltető vagy képviselője árumintát vehet, amelyet szakértővel megvizsgáltat, és a romlottnak tűnő áru forgalomba hozatalát a szakértői vizsgálat elvégzéséig megtilthatja. A vizsgálat eredményeképpen végleg megtilthatja a romlott áru forgalomba hozatalát, és azt a megfelelő hatóságok által zár alá vetetheti, lefoglaltathatja.
<br>
21. Élelmiszerárusítással – a mezőgazdasági kistermelők kivételével – csak olyan személy foglalkozhat, aki a külön jogszabályban foglalt személyi higiénés vizsgálat szerinti alkalmasságát igazolni tudja. E személyek, továbbá a tejet, tejterméket árusító kistermelők kötelesek munka közben e célra rendszeresített védőruhát viselni.
<br>
22. Vizsgálatot igénylő terméket csak valamennyi tétel megvizsgálása után szabad árusítani. Tilos az első szállítmány vizsgálata után „azonos”, de vizsgálat nélküli terméket beszállítani, az árut pótolni.
<br>
23. A piac vásárlók számára kijelölt területén áruszállítás csak kis kocsival, illetve kézi erővel történhet. Az áruk beszállítását a piacnyitás előtt másfél órával lehet megkezdeni. A hivatalos nyitvatartási időben a vásárlók számára kijelölt területen az áruszállítás TILOS!
<br>
24. Az árus az árucikkek árát köteles jól olvashatóan kiírni.
<br>
25. A nyugta, illetve számlaadási kötelezettség teljesítése az árus felelősségi körébe tartozik.
<br>
26. A piacon az árusok 1-3 tonnánál nem nagyobb gépjárművel beállhatnak a Vásár parkolásra kijelölt területeire. A piac ideje alatt a Vásár ingyenes parkolási lehetőséget biztosít a piac bérlői számára a befogadóképesség erejéig.
<br>
27. A piacon elhelyezett áru megőrzése, kezelése és tárolása a helyhasználó/bérlő feladata. Tárolást, raktározást a piac üzemeltetője nem vállal.
<br>
28. Azok, akik zöldség-, gyümölcsfélét, takarmányt hoznak forgalomba, kötelesek a vizsgálatot végzőnek a vegyszeres növényvédelemről vezetett naplót bemutatni, és vizsgálatra ingyenes terménymintát adni.
<br>
29. Az üzemeltető jogosult elrendelni az árusítóhelyeken a kártevő irtást, és a helyhasználót/bérlőt felszólítani az árusítóhely takarítására.
<br>
30. A romlott vagy romlásnak indult és egyéb okokból bűzt terjesztő árut, anyagot a piac területére bevinni, ott tárolni tilos.
<br>
31. Az üzemeltető jogosult ellenőrizni a szakhatósági (tűzvédelmi, egészségügyi, vagyonvédelmi, munkavédelmi stb.) előírások betartását.
<br>
32. A piaci házirend szabályainak megszegése miatt az üzemeltető jogosult a helyhasználati/bérleti engedély visszavonására és a szabálysértési eljárás lefolytatására.
<br>
33. Az üzemeltető gondoskodik a piac rendjének betartásáról. A vásárlók számára kijelölt területek, közlekedési utak, közös használatú helyiségeinek a tisztán tartásáról, a közös használatú terek világításáról, közhasználatú vízvezetékről a Vásár üzemeltetője, a Shopping Mall Kft. gondoskodik a felek között érvényben lévő területhasználati szerződésben foglaltak szerint. A hatósági vizsgálatok elvégzéséhez szükséges helyiséget az üzemeltető és a hatóság számára szükség esetén a Shopping Mall Kft. biztosítja.
<br>
34. A területen található összes üzemben lévő nyilvános illemhelyet a látogatók térítésmentesen használhatják. A piac bérlői számára az üzemeltető külön személyzeti mosdót biztosít a Vásár területén.
<br>
35. Az üzemeltető ellenőrzési kötelezettsége folyamatos teljesítéséről vagy maga vagy az alkalmazásában álló megbízott útján gondoskodik, aki szükség esetén a szabálysértési feljelentést köteles megtenni.
<br>
36. A piac rendjét, az ott árusított termékeket, valamint a jogszabályokban foglaltak betartását Polgármesteri Hivatal jegyző által felhatalmazott ügyintézője is jogosult ellenőrizni.
<br>
37. Az üzemeltető igény esetén egyéb szolgáltatásokat: ivóvíz ellátást, villamos energiát, korlátozott számban eszköz bérbeadást biztosít.
<br>
38. Reklámtevékenység, ügynöki tevékenység, politikai tevékenység a piac egész területén kizárólag az üzemeltető írásbeli hozzájárulásával folytatható.
<br>
39. A piac helyszínéül szolgáló Vásár egyes területein biztonsági térfigyelő rendszer működik. Aki a piac területén tartózkodik, hozzájárul ahhoz, hogy róla felvétel készüljön, melyet biztonsági okokból készít és tárol 30 napig a Vásár üzemeltetője. Az adattárolást és feldolgozást kizárólag a Vásár üzemeltetője végzi és harmadik személynek nem adja tovább. A felvételeket kizárólag biztonsági okokból készítik, valamint az esetlegesen felmerülő vitás kérdések bizonyítása érdekében (közlekedési szabálysértés, árusítási szabályok megsértése, műszaki meghibásodás stb.)
<br>
40. A dohányzás csak a kijelölt helyen megengedett.
<br>
41. Tilos a piacon olyan viselkedést tanúsítani, mely másokat megbotránkoztat.
<br>
42. Az a bérlő/helyhasználó, aki a kipakolásával jelentősen akadályozza a közlekedési útvonalat, úgy, hogy az tűzvédelmi szempontból nem megengedhető, az üzemeltető felszólítására köteles azonnal a kipakolást megszüntetni. A fenti szabálysértés másodszori elkövetése pénzbeli bírsággal sújtható. Amennyiben harmadszor is akadályozza a gyalogos közlekedést, úgy a bérlő/helyhasználó árusítási lehetőségét az üzemeltető megvonja!
<br>
43. A piaci területén a kóstoltatás csakis a helyi Élelmiszerlánc-biztonsági és Állategészségügyi Igazgatóság által előírt szabályok alapján történhet.
<br>
44. Vadon termő gombát a piacon nem lehet árusítani. (Kivéve, ha az árus maga engedéllyel rendelkező gomba szakértő.)
<br>
45. A piacon minden árusnak egyszeri bejelentési kötelezettsége van a piacon folytatott tevékenységéről a helyi önkormányzat felé. Ennek teljesítése az árus felelősségi körébe tartozik. Az üzemeltetőt ennek hiányában nem terheli semmilyen felelősség.
<br>
46. Az árus tudomásul veszi és kifejezetten hozzájárul, hogy az üzemeltető az általa készített és árusítani kívánt termékről információkat osszon meg közösségi oldalain, valamint azt is, hogy a rendezvényen róla és standjáról fotó, illetve videó készülhet, mely kizárólag az üzemeltető tulajdonát képezi és melyet az üzemeltető a későbbiekben hasonló rendezvényeinek promótálására online felületein szabadon, korlátlan ideig felhasználhat.
<br>
Összegezve: A helyszín megfelel a Nemzeti Népegészségügyi Központ és az Állategészségügyi és Élelmiszer-ellenőrző Hivatal által előírt követelményeknek. Az árusok felelőssége – felszólítás esetén – az áruk származási helyének igazolása, az élelmiszer higiénia garantálása, permetezési naplók bemutatása. A nyugta vagy számlaadási kötelezettség teljesítése az árusokra vonatkozó tv. vagy rendelet szerint az árusok felelőssége.
</p>
<script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

                    
         
                    </div>
                </main>
        </div>
    </div>

    <?php 
        displayMessages($error, $msg);
        require_once("footer.html"); 
    ?>

   
</body>
</html>