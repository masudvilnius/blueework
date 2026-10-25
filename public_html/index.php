<?php
// BlueeWork secure form token bootstrap. The public homepage URL remains https://blueework.com/.
$httpsRequest = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $httpsRequest,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();
if (empty($_SESSION['blueework_csrf'])) {
    $_SESSION['blueework_csrf'] = bin2hex(random_bytes(32));
}
$blueeworkCsrf = htmlspecialchars($_SESSION['blueework_csrf'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#073B82" />
  <link rel="canonical" href="https://blueework.com/" />
  <meta property="og:title" content="BlueeWork — Smart Matching. Powered by AI." />
  <meta property="og:description" content="Connect skilled workers, employers and recruitment partners worldwide." />
  <meta name="description" content="BlueeWork connects skilled blue-collar workers, employers and approved recruitment agencies worldwide through smart matching powered by AI." />
  <title>BlueeWork — Smart Matching. Powered by AI.</title>
  <style>
    :root{--navy:#073B82;--blue:#FFB900;--blue2:#0756A8;--ink:#202B3C;--muted:#63758a;--pale:#F1F6FC;--line:#dce6ef;--white:#fff;--green:#14865b;--shadow:0 18px 50px rgba(7,59,130,.12)}
    *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;color:var(--ink);background:#fff;line-height:1.55}a{color:inherit;text-decoration:none}button,input,select,textarea{font:inherit}button,.btn{cursor:pointer;border:0;border-radius:12px;padding:12px 18px;font-weight:750;display:inline-flex;align-items:center;justify-content:center;gap:8px;transition:.2s}button:hover,.btn:hover{transform:translateY(-1px)}.btn-primary{background:var(--blue);color:#073B82}.btn-primary:hover{background:#e6a600;color:#073B82}.btn-outline{border:1px solid #cbd8e5;background:#fff;color:var(--navy)}.btn-dark{background:var(--navy);color:#fff}.container{width:min(1160px,calc(100% - 40px));margin:auto}.topbar{background:var(--navy);color:#dceaf6;font-size:.83rem;padding:8px 0}.topbar .container{display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap}.nav{height:78px;display:flex;align-items:center;justify-content:space-between;gap:24px}.brand{display:flex;align-items:center;gap:10px;font-weight:900;font-size:1.55rem;letter-spacing:-.06em;color:var(--navy)}.brand-mark{height:39px;width:39px;border-radius:12px;background:var(--blue);display:grid;place-items:center;color:#073B82;font-size:1.3rem;letter-spacing:0}.brand span{color:var(--blue2)}.navlinks{display:flex;gap:25px;color:#43576b;font-size:.92rem;font-weight:650}.nav-actions{display:flex;gap:10px;align-items:center}.menu-toggle{display:none;background:transparent;color:var(--navy);font-size:1.4rem;padding:8px}.hero{background:linear-gradient(120deg,#f0f8fd 0%,#fff 58%,#e4f5fd 100%);padding:66px 0 70px;overflow:hidden}.hero-grid{display:grid;grid-template-columns:1.03fr .97fr;gap:48px;align-items:center}.eyebrow{display:inline-flex;gap:8px;align-items:center;color:#073B82;background:#fff2c7;padding:7px 12px;border-radius:999px;font-size:.8rem;font-weight:800;letter-spacing:.04em;text-transform:uppercase}.eyebrow:before{content:"";width:7px;height:7px;background:#FFB900;border-radius:50%}h1{font-size:clamp(2.7rem,5vw,4.6rem);line-height:1.04;letter-spacing:-.065em;color:var(--navy);margin:20px 0}h1 em{font-style:normal;color:var(--blue2)}.hero-copy{font-size:1.1rem;color:var(--muted);max-width:570px}.hero-buttons{display:flex;gap:12px;flex-wrap:wrap;margin:28px 0}.trustline{display:flex;align-items:center;gap:12px;color:#607286;font-size:.86rem}.avatars{display:flex}.avatars i{font-style:normal;border:2px solid white;border-radius:50%;width:29px;height:29px;margin-right:-7px;background:#c4eaf8;display:grid;place-items:center;font-size:.72rem}.hero-visual{position:relative}.hero-photo{height:430px;border-radius:28px;overflow:hidden;background:linear-gradient(145deg,#8ecce6,#153a59);box-shadow:var(--shadow);position:relative}.hero-photo img{height:100%;width:100%;object-fit:cover;display:block}.photo-overlay{position:absolute;inset:0;background:linear-gradient(0deg,rgba(4,24,43,.62),transparent 55%)}.photo-caption{position:absolute;bottom:22px;left:24px;color:white}.photo-caption strong{display:block;font-size:1.1rem}.float-card{position:absolute;background:white;border:1px solid #e7edf3;box-shadow:var(--shadow);padding:15px 17px;border-radius:16px}.float-card.top{top:25px;left:-28px}.float-card.bottom{right:-18px;bottom:38px}.float-card strong{display:block;color:var(--navy);font-size:1.1rem}.float-card small{color:var(--muted)}.float-icon{display:inline-grid;place-items:center;width:34px;height:34px;background:#fff2c7;color:#073B82;border-radius:10px;margin-right:8px}.section{padding:78px 0}.section-soft{background:#f6fafc}.section-heading{text-align:center;max-width:720px;margin:0 auto 38px}.section-heading h2{font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;letter-spacing:-.045em;color:var(--navy);margin:12px 0}.section-heading p{color:var(--muted);margin:0}.portal-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}.portal-card{border:1px solid var(--line);border-radius:20px;padding:26px;background:white;box-shadow:0 5px 22px rgba(10,36,64,.035);display:flex;flex-direction:column;align-items:flex-start}.portal-icon{height:52px;width:52px;display:grid;place-items:center;background:#fff2c7;border-radius:15px;color:#073B82;font-size:1.55rem}.portal-card h3{font-size:1.25rem;color:var(--navy);margin:18px 0 8px}.portal-card p{color:var(--muted);font-size:.95rem;margin:0 0 18px}.portal-card ul{padding-left:19px;color:#52667b;font-size:.9rem;margin:0 0 23px}.portal-card li{margin:7px 0}.portal-card .btn{margin-top:auto;width:100%}.steps{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}.step{padding:22px;border-top:3px solid var(--blue);background:#fff;border-radius:0 0 14px 14px}.step-num{font-size:.8rem;color:var(--blue2);font-weight:900;letter-spacing:.1em}.step h3{color:var(--navy);margin:9px 0}.step p{color:var(--muted);font-size:.92rem;margin:0}.cta{background:var(--navy);color:white;padding:50px;border-radius:26px;display:flex;justify-content:space-between;align-items:center;gap:25px}.cta h2{font-size:clamp(1.8rem,3vw,2.6rem);letter-spacing:-.04em;margin:0 0 8px}.cta p{color:#c6d7e7;margin:0}.cta-actions{display:flex;gap:10px;flex-wrap:wrap}.cta .btn-outline{background:transparent;border-color:#6c849b;color:white}.footer{background:#071b30;color:#c8d7e5;padding:48px 0 20px}.footer-grid{display:grid;grid-template-columns:1.25fr .8fr .9fr 1.1fr 1.35fr;gap:26px}.footer .brand{color:white}.footer p{color:#9eb2c6;font-size:.9rem;max-width:310px}.footer h4{color:white;margin:0 0 14px}.footer a:not(.brand){display:block;color:#aebfd0;margin:9px 0;font-size:.9rem}.footer .legal-entity{font-size:.84rem;line-height:1.55;color:#b8c8d8;margin:0 0 17px}.footer .legal-entity strong{display:block;color:#fff;font-size:.9rem;margin-bottom:4px}.footer .legal-entity span{display:block}.footer .social-heading{margin-top:20px}.social-links{display:flex;align-items:center;gap:10px;margin-top:12px}.footer .social-links a{display:grid;place-items:center;width:37px;height:37px;margin:0;border:1px solid #3b536b;border-radius:11px;background:#102f50;color:#fff;transition:background .2s,transform .2s}.footer .social-links a:hover{background:#0756A8;transform:translateY(-2px)}.footer .social-links svg{width:18px;height:18px;display:block;fill:currentColor}.footer .social-links a:focus-visible{outline:2px solid #FFB900;outline-offset:3px}.copyright{border-top:1px solid #294055;margin-top:35px;padding-top:18px;font-size:.82rem;color:#91a7bb;display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap}
@media(max-width:1000px){.footer-grid{grid-template-columns:repeat(3,minmax(0,1fr))}}
@media(max-width:650px){.footer-grid{grid-template-columns:1fr 1fr;gap:25px}.footer-grid>div:first-child{grid-column:1/-1}.footer-grid>div:last-child{grid-column:1/-1}}
@media(max-width:420px){.footer-grid{grid-template-columns:1fr}.footer-grid>div:first-child,.footer-grid>div:last-child{grid-column:auto}}
.trades-section{background:#fff}.trade-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:10px}.trade-chip{display:flex;align-items:center;min-height:52px;padding:12px 14px;border:1px solid var(--line);border-radius:12px;background:#fbfdff;color:#29445d;font-weight:650;font-size:.9rem}.trade-chip:before{content:"✓";display:grid;place-items:center;flex:0 0 20px;width:20px;height:20px;margin-right:8px;border-radius:6px;background:#fff2c7;color:#073B82;font-size:.75rem;font-weight:900}.trade-footnote{text-align:center;color:var(--muted);font-size:.85rem;margin:22px auto 0;max-width:800px}

    .brand-image{display:flex;align-items:center;flex:0 0 auto;width:220px;max-width:31vw;}
    .brand-image img{display:block;width:100%;height:auto;object-fit:contain;}
    :focus-visible{outline:3px solid #0756A8;outline-offset:3px}
    .small-help{margin:0;color:var(--muted);font-size:.82rem}
    .role-row{display:grid;grid-template-columns:minmax(0,1.55fr) minmax(88px,.55fr) minmax(130px,.9fr) 42px;gap:10px;align-items:end;padding:14px;border:1px solid var(--line);border-radius:13px;background:#fbfdff;margin:10px 0}
    .role-row .field{min-width:0}.role-row label{font-size:.78rem}.role-row input,.role-row select{min-width:0;padding:10px 9px}.role-remove{height:42px;width:42px;padding:0;border:1px solid #efcaca;background:#fff6f6;color:#9f2f2f;border-radius:10px;font-size:1.15rem}
    .form-section-title{font-size:.96rem;color:var(--navy);font-weight:850;margin:3px 0 5px}
    @media(max-width:700px){.brand-image{width:185px;max-width:54vw}.role-row{grid-template-columns:1fr 1fr;}.role-row .field:first-child{grid-column:1/-1}.role-row .field:last-of-type{grid-column:1/-1}.role-remove{grid-column:2;justify-self:end}}


    .partner-directory{background:#f6f9fd}
    .approved-partner-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px}
    .partner-directory-empty{grid-column:1/-1;border:1px dashed #b8c9dd;border-radius:20px;background:#fff;padding:34px 20px;text-align:center}
    .partner-empty-mark{width:54px;height:54px;border-radius:16px;background:#fff2c7;color:#073B82;font-weight:950;display:grid;place-items:center;margin:0 auto 13px}
    .partner-directory-empty h3{margin:0 0 8px;color:var(--navy);font-size:1.15rem}
    .partner-directory-empty p{max-width:620px;margin:0 auto 18px;color:var(--muted)}
    .partner-logo-card{border:1px solid var(--line);background:white;border-radius:16px;padding:20px;display:flex;align-items:center;justify-content:center;min-height:135px}
    .partner-logo-card img{max-width:100%;max-height:76px;object-fit:contain}
    .partner-logo-upload{border:1px dashed #adc0d5;border-radius:14px;background:#fbfdff;padding:16px}
    .partner-logo-preview-wrap{display:flex;align-items:center;gap:14px;margin-top:12px}
    .partner-logo-preview-wrap img{display:none;width:116px;height:76px;object-fit:contain;border:1px solid var(--line);border-radius:10px;padding:7px;background:white}
    .partner-logo-preview-wrap img.visible{display:block}
    .partner-logo-preview-text{font-size:.83rem;color:var(--muted)}
    .partner-directory-note{text-align:center;font-size:.82rem;color:var(--muted);margin:18px 0 0}
    @media(max-width:900px){.approved-partner-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:560px){.approved-partner-grid{grid-template-columns:1fr}.partner-directory-empty{padding:26px 16px}}


    /* Header: the only primary actions are candidate, partner and employer entry points. */
    .main-nav{height:auto;min-height:88px;padding-top:12px;padding-bottom:12px;gap:20px}
    .main-nav .navlinks{display:none!important}
    .main-nav .nav-actions{margin-left:auto;display:flex;gap:10px;align-items:center}
    .main-nav .nav-cta{white-space:normal;min-height:46px;line-height:1.25;text-align:center;padding:11px 15px;font-size:.86rem}
    .main-nav .candidate-cta{border-color:#b9cbe0}
    .main-nav .partner-cta{background:#fff;border-color:#b9cbe0}
    .main-nav .employer-cta{background:#FFB900;color:#073B82}
    .main-nav .employer-cta:hover{background:#e8a900}
    .matching-section{background:#f5f8fc}
    .match-demo-shell{display:grid;grid-template-columns:minmax(0,1.35fr) minmax(300px,.75fr);gap:20px;align-items:stretch;background:#eef3f9;border:1px solid #dce6f1;border-radius:26px;padding:20px;box-shadow:0 20px 55px rgba(7,59,130,.07)}
    .match-demo-main,.match-demo-sidebar{min-width:0;background:#fff;border:1px solid #e0e8f1;border-radius:20px;padding:20px}
    .match-demo-head{display:flex;justify-content:space-between;align-items:start;gap:12px;margin-bottom:15px}
    .match-demo-overline{font-size:.68rem;letter-spacing:.13em;color:#0756A8;font-weight:900}
    .match-demo-head h3,.match-sidebar-top h3{font-size:1.22rem;letter-spacing:-.035em;color:#073B82;margin:5px 0}
    .match-demo-head p{font-size:.8rem;color:var(--muted);margin:0}
    .match-demo-pill{display:inline-flex;align-items:center;gap:7px;background:#fff2c7;color:#073B82;border-radius:999px;padding:8px 10px;font-size:.7rem;font-weight:850;white-space:nowrap}
    .match-demo-pill i{width:7px;height:7px;border-radius:100%;background:#FFB900;display:inline-block}
    .match-demo-stage{display:grid;place-items:center;padding:6px 10px 0;background:radial-gradient(circle at 10% 0%,#eff6ff,transparent 50%),linear-gradient(140deg,#f1f5f9,#e7eef6);border-radius:18px}
    .match-job-card{width:min(100%,460px);background:#fff;border:1px solid #e1e8f0;border-radius:20px;overflow:hidden;box-shadow:0 16px 36px #073b8212;transition:transform .2s,opacity .2s}
    .match-job-art{height:205px;position:relative;background:#c7d9e6}
    .match-job-art svg{display:block;width:100%;height:100%}
    .match-art-tag,.match-fit-score{position:absolute;top:12px;border-radius:8px;padding:7px 9px;font-size:.65rem;font-weight:900;letter-spacing:.04em;background:#ffffffeb;color:#073B82}
    .match-art-tag{left:12px}.match-fit-score{right:12px;background:#073B82;color:#fff}
    .match-job-info{padding:17px}
    .match-company-line{display:flex;gap:9px;align-items:center}
    .match-company-logo{height:34px;width:34px;display:grid;place-items:center;background:#073B82;color:#FFB900;border-radius:10px;font-weight:950;flex:none}
    .match-company-line>div:nth-child(2){display:flex;flex-direction:column;gap:2px;min-width:0}
    .match-company-line strong{font-size:.76rem;color:#233c55;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:260px}
    .match-company-line span{font-size:.65rem;color:var(--muted)}
    .match-demo-verified{margin-left:auto;background:#edf6ff;color:#0756A8!important;border-radius:8px;padding:6px 8px;font-weight:850;white-space:nowrap}
    .match-job-info h4{font-size:1.6rem;letter-spacing:-.05em;color:#073B82;margin:13px 0 10px}
    .match-job-tags{display:flex;gap:7px;flex-wrap:wrap}
    .match-job-tags span{font-size:.68rem;font-weight:700;padding:7px 9px;border-radius:8px;background:#f1f5fa;color:#52667b}
    .match-pay-line{display:flex;justify-content:space-between;gap:10px;align-items:end;margin-top:15px;padding-top:13px;border-top:1px solid #e7edf4}
    .match-pay-line>strong{font-size:1.1rem;color:#162f4f;letter-spacing:-.025em}
    .match-pay-line small{font-size:.65rem;color:var(--muted);font-weight:600;letter-spacing:0}
    .match-pay-line>span{font-size:.67rem;color:#0756A8;font-weight:850;text-align:right}
    .match-skill-chips{display:flex;gap:6px;flex-wrap:wrap;margin-top:12px}
    .match-skill-chips span{padding:6px 8px;background:#fff5d4;color:#5b4a13;border-radius:7px;font-size:.65rem;font-weight:750}
    .match-demo-disclaimer{color:#7a8796;font-size:.64rem;line-height:1.45;margin:12px 0 0}
    .match-actions{display:flex;justify-content:center;gap:13px;margin-top:15px}
    .match-action{height:44px;width:44px;border-radius:50%;display:grid;place-items:center;border:1px solid #dce5ef;background:#fff;color:#62758a;font-size:1.25rem;box-shadow:0 5px 14px #073b820e}
    .match-action:hover{transform:translateY(-2px)}.match-pass{color:#c95555}.match-details{color:#0756A8;font-weight:900}.match-like{height:53px;width:53px;background:#FFB900;border:0;color:#073B82;font-size:1.35rem}.match-save{color:#0756A8}
    .match-action-hint{text-align:center;font-size:.67rem;color:var(--muted);margin:7px 0 0}
    .match-sidebar-top{display:flex;justify-content:space-between;align-items:center;gap:10px}
    .match-sidebar-icon{height:39px;width:39px;border-radius:12px;background:#fff2c7;color:#073B82;display:grid;place-items:center;font-size:1.3rem}
    .match-side-copy{font-size:.78rem;color:var(--muted);line-height:1.6;margin:7px 0 16px}
    .match-profile-card{border-radius:16px;background:#f5f8fc;border:1px solid #e3eaf3;padding:15px;display:grid;grid-template-columns:44px 1fr auto;gap:4px 10px;align-items:center}
    .match-profile-avatar{grid-row:1/3;width:44px;height:44px;border-radius:13px;background:#e0ebf7;display:grid;place-items:center;font-size:1.45rem}
    .match-profile-card>div:nth-child(2){display:flex;flex-direction:column;gap:3px;min-width:0}
    .match-profile-card>div:nth-child(2) strong{font-size:.77rem;color:#183a60}
    .match-profile-card>div:nth-child(2) span{font-size:.65rem;color:var(--muted)}
    .match-profile-status{font-size:.62rem;font-weight:850;color:#8c6511;background:#fff0be;border-radius:7px;padding:5px 7px}
    .match-progress-label{grid-column:1/-1;display:flex;justify-content:space-between;margin-top:11px;font-size:.67rem;font-weight:750;color:#516579}
    .match-progress-label b{color:#0756A8}
    .match-progress{grid-column:1/-1;height:7px;border-radius:99px;background:#dfe8f2;overflow:hidden}
    .match-progress i{display:block;width:72%;height:100%;background:#0756A8;border-radius:99px}
    .match-profile-tags{grid-column:1/-1;display:flex;gap:6px;flex-wrap:wrap;margin-top:8px}
    .match-profile-tags span{font-size:.62rem;background:#fff;border:1px solid #dfe7f0;border-radius:7px;padding:6px 7px;color:#53677c;font-weight:700}
    .match-profile-button{grid-column:1/-1;width:100%;margin-top:9px;font-size:.77rem}
    .match-how-title{font-size:.65rem;color:#0756A8;font-weight:900;letter-spacing:.1em;margin:21px 0 12px}
    .match-how-item{display:flex;gap:10px;align-items:start;margin-top:12px}
    .match-how-item>b{width:26px;height:26px;flex:none;border-radius:8px;background:#fff2c7;color:#073B82;display:grid;place-items:center;font-size:.64rem}
    .match-how-item p{margin:0;font-size:.73rem;line-height:1.5;color:var(--muted)}
    .match-how-item strong{color:#163a62;font-size:.76rem}
    @media(max-width:1020px){.main-nav .nav-cta{padding:10px 11px;font-size:.79rem}.main-nav{gap:14px}.match-demo-shell{grid-template-columns:1fr}.match-demo-sidebar{display:grid;grid-template-columns:1fr 1fr;gap:0 18px}.match-sidebar-top,.match-side-copy,.match-profile-card{grid-column:1}.match-how-title,.match-how-item{grid-column:2}.match-how-title{grid-row:1;margin-top:0}.match-how-item{align-self:start}}
    @media(max-width:740px){.main-nav{flex-wrap:wrap;justify-content:center}.main-nav .brand-image{width:195px;max-width:70vw;margin:0 auto 6px}.main-nav .nav-actions{flex:1 0 100%;width:100%;margin:0;display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:7px}.main-nav .nav-cta{height:52px;padding:7px 6px;font-size:.72rem;border-radius:10px}.match-demo-shell{padding:11px;border-radius:20px}.match-demo-main,.match-demo-sidebar{padding:13px}.match-demo-sidebar{display:block}.match-how-title{margin-top:20px}.match-demo-head{flex-direction:column}.match-demo-pill{align-self:start}}

    .honeypot{position:absolute!important;left:-10000px!important;top:auto!important;width:1px!important;height:1px!important;overflow:hidden!important;white-space:nowrap!important}.honeypot input{position:absolute!important;left:-10000px!important}.form-status-note{font-size:.9rem;color:var(--muted)}
/* Dialogs and forms */
dialog{border:0;border-radius:22px;padding:0;width:min(760px,calc(100% - 24px));max-height:90vh;box-shadow:0 30px 100px #04182b66;color:var(--ink)}dialog::backdrop{background:#061a2caa;backdrop-filter:blur(4px)}.dialog-head{padding:23px 26px;background:#f1f8fc;border-bottom:1px solid var(--line);display:flex;justify-content:space-between;align-items:flex-start;gap:16px}.dialog-head h2{margin:0;color:var(--navy);letter-spacing:-.03em}.dialog-head p{margin:4px 0 0;color:var(--muted);font-size:.9rem}.close{background:transparent;padding:4px 8px;font-size:1.5rem;color:#607286}.dialog-body{padding:25px 26px;overflow:auto;max-height:calc(90vh - 110px)}.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}.field{display:flex;flex-direction:column;gap:6px}.field.full{grid-column:1/-1}.field label{font-weight:750;font-size:.88rem;color:#263e55}.field input,.field select,.field textarea{width:100%;border:1px solid #cfdae5;border-radius:10px;padding:11px 12px;background:white;color:var(--ink);outline:none}.field input:focus,.field select:focus,.field textarea:focus{border-color:var(--blue2);box-shadow:0 0 0 3px #0756A81b}.field textarea{min-height:90px;resize:vertical}.form-note{background:#fff8e8;color:#76551a;padding:12px 14px;border-radius:10px;font-size:.84rem;margin:17px 0}.form-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px}.success{display:none;background:#e7f8ef;border:1px solid #b8e7cd;color:#145a3b;border-radius:12px;padding:16px;margin-top:16px}.success.show{display:block}.checks{display:flex;gap:12px;flex-wrap:wrap}.checks label{font-weight:500;display:flex;align-items:center;gap:7px}.section-anchor{scroll-margin-top:20px}
@media(max-width:900px){.trade-grid{grid-template-columns:repeat(3,1fr)}.navlinks{display:none;position:absolute;z-index:10;top:122px;left:0;right:0;background:white;padding:22px 24px;box-shadow:var(--shadow);flex-direction:column;gap:18px}.navlinks.open{display:flex}.menu-toggle{display:inline-flex}.nav-actions .btn-outline{display:none}.hero-grid{grid-template-columns:1fr;gap:36px}.hero-visual{max-width:620px;width:100%;margin:0 auto}.hero-photo{height:380px}.portal-grid{grid-template-columns:1fr 1fr}.portal-card:last-child{grid-column:1/-1}.steps{grid-template-columns:1fr 1fr}.footer-grid{grid-template-columns:1fr 1fr}.cta{padding:35px;align-items:flex-start;flex-direction:column}}
@media(max-width:560px){.trade-grid{grid-template-columns:repeat(2,1fr);gap:8px}.trade-chip{font-size:.82rem;padding:10px}.container{width:min(100% - 28px,1160px)}.topbar .container{justify-content:center}.topbar .container span:last-child{display:none}.nav{height:68px}.navlinks{top:110px}.nav-actions>.btn-primary{display:none}.hero{padding:48px 0}.hero-photo{height:300px}.float-card.top{left:-4px;top:12px}.float-card.bottom{right:-4px;bottom:15px}.section{padding:56px 0}.portal-grid,.steps,.footer-grid{grid-template-columns:1fr}.portal-card:last-child{grid-column:auto}.cta{padding:26px 22px}.form-grid{grid-template-columns:1fr}.field.full{grid-column:auto}.dialog-body{padding:20px}.dialog-head{padding:19px 20px}.copyright{display:block}.copyright span{display:block;margin-top:6px}}
  </style>
</head>
<body>
  <div class="topbar"><div class="container"><span>🌍 Connecting people, skills and opportunities</span><span>Connecting talent with opportunity, across borders.</span></div></div>
  <header class="container nav main-nav">
    <a class="brand brand-image" href="#" aria-label="BlueeWork home"><img src="data:image/jpeg;base64,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" alt="BlueeWork logo" /></a>
    <div class="nav-actions" aria-label="Get started">
      <button class="btn btn-outline nav-cta candidate-cta" data-open="candidateDialog">Create profile &amp; find work</button>
      <button class="btn btn-outline nav-cta partner-cta" data-open="partnerDialog">Become a partner</button>
      <button class="btn btn-primary nav-cta employer-cta" data-open="employerDialog">Hire employees ↗</button>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="container hero-grid">
        <div>
          <span class="eyebrow">Global workforce solutions</span>
          <h1>Smart matching.<br><em>Powered by AI.</em></h1>
          <p class="hero-copy">BlueeWork connects skilled blue-collar workers with companies around the world. Smart matching powered by AI is designed to help align worker skills with employer requirements, while recruitment agencies can join through a straightforward partner onboarding process.</p>
          <div class="hero-buttons"><button class="btn btn-primary" data-open="candidateDialog">Create profile &amp; find work ↗</button><button class="btn btn-outline" data-open="employerDialog">Hire employees</button></div>
          <div class="trustline"><div class="avatars"><i>⚡</i><i>🔧</i><i>🦺</i></div><span>Connecting skills to opportunity</span></div>
        </div>
        <div class="hero-visual">
          <div class="hero-photo">
            <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1200&q=85" alt="Skilled construction workers at a job site" loading="eager" fetchpriority="high" />
            <div class="photo-overlay"></div><div class="photo-caption"><strong>Smart matching powered by AI.</strong><span>Connecting great people with great opportunities.</span></div>
          </div>
          <div class="float-card top"><span class="float-icon">✓</span><strong>Verified partners</strong><small>Trust through transparency</small></div>
          <div class="float-card bottom"><strong>One connected network</strong><small>Workers · Employers · Partners</small></div>
        </div>
      </div>
    </section>


    <section class="section matching-section" id="matching-preview">
      <div class="container">
        <div class="section-heading">
          <span class="eyebrow">The BlueeWork platform vision</span>
          <h2>Smart matching. Built around real skills.</h2>
          <p>Our planned experience will help candidates discover relevant jobs and help employers compare skills against their requirements. This interactive preview shows the direction of the product.</p>
        </div>
        <div class="match-demo-shell">
          <div class="match-demo-main">
            <div class="match-demo-head">
              <div><span class="match-demo-overline">BLUEEWORK MATCH PREVIEW</span><h3>Opportunities for your skills</h3><p>Illustrative jobs · Not live vacancies</p></div>
              <span class="match-demo-pill"><i></i> Concept preview</span>
            </div>
            <div class="match-demo-stage">
              <article class="match-job-card" id="matchJobCard">
                <div class="match-job-art">
                  <svg viewBox="0 0 620 260" role="img" aria-label="Illustration of skilled tradespeople at an industrial worksite" xmlns="http://www.w3.org/2000/svg">
                    <defs><linearGradient id="bwSky" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#d9eaf6"/><stop offset="1" stop-color="#8eafc9"/></linearGradient></defs>
                    <rect width="620" height="260" fill="url(#bwSky)"/><circle cx="520" cy="48" r="25" fill="#FFB900" opacity=".9"/>
                    <path d="M0 206 94 155 184 183 293 111 393 186 484 144 620 194V260H0Z" fill="#8aabc0" opacity=".7"/>
                    <path d="M40 50H225V220H40Z" fill="#e9edf0"/><path d="M58 70H207V220H58Z" fill="#c5d6e0"/><path d="M58 108H207M58 148H207M58 188H207M100 70V220M151 70V220M188 70V220" stroke="#fff" stroke-width="6"/>
                    <path d="M272 80H580V220H272Z" fill="#d7e0e7"/><path d="M272 80H580V98H272Z" fill="#0756A8"/><path d="M296 116H352V162H296ZM373 116H429V162H373ZM450 116H506V162H450Z" fill="#92b0c4"/><path d="M0 221H620V260H0Z" fill="#9da9af"/>
                    <g transform="translate(244 84)"><path d="M30 48 22 94 15 133H34L48 96 62 133H81L70 92 69 48Z" fill="#073B82"/><path d="M26 50 18 87 76 87 69 50Z" fill="#FFB900"/><path d="M27 52 27 82M46 52V82M65 52V82" stroke="#fff1bf" stroke-width="5"/><path d="M33 145 24 174H45L52 145M61 145 69 174H90L79 145" fill="#273d55"/><path d="M22 174H47V183H15ZM68 174H92V183H65" fill="#f4f6fa"/><rect x="34" y="17" width="31" height="38" rx="12" fill="#bd8662"/><path d="M25 25Q49 -7 74 25L69 31H30Z" fill="#FFB900"/><path d="M21 25H78L73 33H26Z" fill="#e6a800"/><path d="M25 61 4 96 13 104 35 78M70 61 93 94 84 101 62 78" stroke="#bd8662" stroke-width="13" stroke-linecap="round"/><path d="M5 97 15 104M84 101 96 95" stroke="#073B82" stroke-width="10" stroke-linecap="round"/></g>
                    <path d="M0 244H620" stroke="#fff" stroke-width="3" stroke-dasharray="28 16" opacity=".8"/>
                  </svg>
                  <span class="match-art-tag" id="matchJobTag">SKILLS MATCH</span>
                  <span class="match-fit-score" id="matchFit">94% match</span>
                </div>
                <div class="match-job-info">
                  <div class="match-company-line"><div class="match-company-logo" id="matchCompanyLogo">N</div><div><strong id="matchCompany">NordBuild Construction</strong><span id="matchCompanyCheck">Company profile example</span></div><span class="match-demo-verified">Demo</span></div>
                  <h4 id="matchTitle">Skilled Welder</h4>
                  <div class="match-job-tags"><span id="matchLocation">📍 Vilnius, Lithuania</span><span id="matchContract">Full-time</span><span id="matchExperience">3+ years</span></div>
                  <div class="match-pay-line"><strong id="matchPay">€2,400–3,000 <small>/ month gross*</small></strong><span id="matchSkillCount">4 related skills</span></div>
                  <div class="match-skill-chips" id="matchSkillChips"><span>MIG / TIG welding</span><span>Technical drawings</span><span>Site safety</span></div>
                  <p class="match-demo-disclaimer">Illustrative data for design demonstration only. Match scores and jobs are not live or AI-generated.</p>
                </div>
              </article>
            </div>
            <div class="match-actions">
              <button class="match-action match-pass" id="matchPass" aria-label="Skip this example job" title="Skip">×</button>
              <button class="match-action match-details" id="matchDetails" aria-label="View match explanation" title="View details">i</button>
              <button class="match-action match-like" id="matchLike" aria-label="I'm interested" title="Interested">♥</button>
              <button class="match-action match-save" id="matchSave" aria-label="Save example job" title="Save for later">☆</button>
            </div>
            <p class="match-action-hint" id="matchActionHint">Skip · Details · Interested · Save for later</p>
          </div>
          <aside class="match-demo-sidebar">
            <div class="match-sidebar-top"><div><span class="match-demo-overline">CANDIDATE PROFILE</span><h3>Skills first</h3></div><span class="match-sidebar-icon">✳</span></div>
            <p class="match-side-copy">The planned matching experience will consider the information candidates choose to share and the requirements employers submit.</p>
            <div class="match-profile-card"><div class="match-profile-avatar">👷</div><div><strong>Your worker profile</strong><span>Candidate profile preview</span></div><span class="match-profile-status">Draft</span>
              <div class="match-progress-label"><span>Example profile completeness</span><b>72%</b></div><div class="match-progress"><i></i></div>
              <div class="match-profile-tags"><span>Trade skills</span><span>Experience</span><span>Certificates</span><span>Availability</span></div>
              <button class="btn btn-primary match-profile-button" data-open="candidateDialog">Create your profile →</button>
            </div>
            <div class="match-how-title">HOW THE MATCHING PLATFORM MAY WORK</div>
            <div class="match-how-item"><b>01</b><p><strong>Build a profile</strong><br>Capture trade skills, experience, certifications and preferences.</p></div>
            <div class="match-how-item"><b>02</b><p><strong>Compare requirements</strong><br>Review relevant job criteria and explain why a role may fit.</p></div>
            <div class="match-how-item"><b>03</b><p><strong>Connect responsibly</strong><br>Let candidates and employers choose when to proceed.</p></div>
          </aside>
        </div>
      </div>
    </section>

    <section class="section" id="portals">
      <div class="container">
        <div class="section-heading"><span class="eyebrow">Three onboarding forms</span><h2>One global workforce platform.</h2><p>Choose the form that fits you: Partner Agency onboarding, Company / Employer registration and manpower requisition, or Candidate / Job Seeker registration. BlueeWork brings the three sides together in one global workforce network.</p></div>
        <div class="portal-grid">
          <article class="portal-card" id="candidates"><div class="portal-icon">👷</div><h3>Candidate / Job Seeker</h3><p>Create a profile and make your trade skills visible to employers and approved recruitment partners around the world.</p><ul><li>Show trades, skills and experience</li><li>Add certificates and languages</li><li>Share your availability and preferred locations</li></ul><button class="btn btn-outline" data-open="candidateDialog">Create candidate profile →</button></article>
          <article class="portal-card" id="employers"><div class="portal-icon">🏗️</div><h3>Company / Employer</h3><p>Request the right people from a global skilled-worker network with a clear, structured manpower requisition.</p><ul><li>Specify headcount by trade</li><li>Set experience and qualifications</li><li>Add location, terms and start date</li></ul><button class="btn btn-primary" data-open="employerDialog">Submit a requisition →</button></article>
          <article class="portal-card" id="partners"><div class="portal-icon">🤝</div><h3>Partner Agency</h3><p>Join the international recruitment network with a straightforward agency registration and KYC review process.</p><ul><li>South Asia, Middle East and Europe</li><li>Company, licence and representative details</li><li>Secure KYC review workflow</li></ul><button class="btn btn-outline" data-open="partnerDialog">Start partner onboarding →</button></article>
        </div>
      </div>
    </section>


    <section class="section section-soft partner-directory" id="global-partners">
      <div class="container">
        <div class="section-heading">
          <span class="eyebrow">Our global network</span>
          <h2>Meet our recruitment partners.</h2>
          <p>Approved recruitment agencies can showcase their company logo here, helping employers discover trusted partner agencies across regions and markets.</p>
        </div>
        <!-- Production integration: render only backend records with partner.status === "approved" and a permitted logo URL. -->
        <div id="approvedPartnerGrid" class="approved-partner-grid" aria-live="polite">
          <div class="partner-directory-empty" id="partnerDirectoryEmpty">
            <div class="partner-empty-mark" aria-hidden="true">BW</div>
            <h3>Our partner network is growing</h3>
            <p>Partner agency logos will appear here after their registration details have been reviewed and their agency has been approved by BlueeWork.</p>
            <button class="btn btn-outline" data-open="partnerDialog">Apply to become a partner →</button>
          </div>
        </div>
        <p class="partner-directory-note">Only verified and approved agency profiles should be displayed. Logo publication is subject to partner approval and brand-use permission.</p>
      </div>
    </section>

    <section class="section trades-section" id="trades">
      <div class="container">
        <div class="section-heading"><span class="eyebrow">50 skilled worker categories</span><h2>Skills for industries around the world.</h2><p>From construction and manufacturing to logistics, energy and food production, BlueeWork is designed to help companies connect with the right skilled people across borders.</p></div>
        <div class="trade-grid">
          <span class="trade-chip">Electricians</span>
          <span class="trade-chip">Industrial electricians</span>
          <span class="trade-chip">Welders</span>
          <span class="trade-chip">Pipe welders</span>
          <span class="trade-chip">Fabricators</span>
          <span class="trade-chip">Plumbers</span>
          <span class="trade-chip">Pipefitters</span>
          <span class="trade-chip">HVAC technicians</span>
          <span class="trade-chip">Refrigeration technicians</span>
          <span class="trade-chip">Solar panel installers</span>
          <span class="trade-chip">Carpenters</span>
          <span class="trade-chip">Joiners</span>
          <span class="trade-chip">Formwork carpenters</span>
          <span class="trade-chip">Steel fixers / rebar workers</span>
          <span class="trade-chip">Masons / bricklayers</span>
          <span class="trade-chip">Concrete workers</span>
          <span class="trade-chip">Plasterers</span>
          <span class="trade-chip">Painters</span>
          <span class="trade-chip">Tilers</span>
          <span class="trade-chip">Roofers</span>
          <span class="trade-chip">Glaziers</span>
          <span class="trade-chip">Drywall installers</span>
          <span class="trade-chip">Insulation installers</span>
          <span class="trade-chip">Scaffolders</span>
          <span class="trade-chip">Crane operators</span>
          <span class="trade-chip">Forklift operators</span>
          <span class="trade-chip">Excavator operators</span>
          <span class="trade-chip">Heavy equipment operators</span>
          <span class="trade-chip">Truck drivers</span>
          <span class="trade-chip">Bus drivers</span>
          <span class="trade-chip">Automotive mechanics</span>
          <span class="trade-chip">Diesel mechanics</span>
          <span class="trade-chip">Industrial mechanics</span>
          <span class="trade-chip">Maintenance technicians</span>
          <span class="trade-chip">CNC machine operators</span>
          <span class="trade-chip">Machine operators</span>
          <span class="trade-chip">Production line operators</span>
          <span class="trade-chip">Quality control inspectors</span>
          <span class="trade-chip">Industrial cleaners</span>
          <span class="trade-chip">Warehouse workers</span>
          <span class="trade-chip">Logistics / material handlers</span>
          <span class="trade-chip">Rigging and lifting technicians</span>
          <span class="trade-chip">Shipyard workers</span>
          <span class="trade-chip">Oil and gas technicians</span>
          <span class="trade-chip">Mining technicians</span>
          <span class="trade-chip">Food production workers</span>
          <span class="trade-chip">Butchers / meat processors</span>
          <span class="trade-chip">Bakers</span>
          <span class="trade-chip">Landscaping / grounds workers</span>
          <span class="trade-chip">Agricultural workers</span>
        </div>
        <p class="trade-footnote">These are example categories to start with. The platform can be expanded with additional trades, specialisations, certificates and country-specific requirements.</p>
      </div>
    </section>

    <section class="section section-soft" id="how-it-works">
      <div class="container">
        <div class="section-heading"><span class="eyebrow">Simple by design</span><h2>From request to the right people</h2><p>A clear process helps each side understand what happens next.</p></div>
        <div class="steps">
          <div class="step"><span class="step-num">STEP 01</span><h3>Register</h3><p>Workers, employers and recruitment agencies submit the information relevant to their role.</p></div>
          <div class="step"><span class="step-num">STEP 02</span><h3>Review</h3><p>Profiles and partner documents can be checked by the BlueeWork team before approval.</p></div>
          <div class="step"><span class="step-num">STEP 03</span><h3>Match</h3><p>Employer requirements are compared with relevant trades, experience and availability.</p></div>
          <div class="step"><span class="step-num">STEP 04</span><h3>Coordinate</h3><p>The parties follow up on shortlisting, interviews, documentation and hiring arrangements.</p></div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container"><div class="cta"><div><h2>Build your workforce with BlueeWork.</h2><p>Start with a hiring request or apply to join our partner network.</p></div><div class="cta-actions"><button class="btn btn-primary" data-open="employerDialog">Request workers</button><button class="btn btn-outline" data-open="partnerDialog">Become a partner</button></div></div></div>
    </section>
  </main>

  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div>
          <a class="brand" href="#" aria-label="BlueeWork home"><span class="brand-mark">BW</span> Bluee<span>Work</span></a>
          <p>Smart matching powered by AI. Connecting skilled workers, employers and recruitment partners around the world.</p>
          <h4 class="social-heading">Follow BlueeWork</h4>
          <div class="social-links" aria-label="BlueeWork social media">
            <a href="#" data-social-link="Facebook" aria-label="BlueeWork on Facebook" title="Facebook profile URL to be added">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 21v-8h2.7l.4-3.1h-3.1v-2c0-.9.3-1.5 1.6-1.5h1.7V3.6c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.1H7.3V13h2.8v8h3.4z"/></svg>
            </a>
            <a href="#" data-social-link="LinkedIn" aria-label="BlueeWork on LinkedIn" title="LinkedIn profile URL to be added">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5.2 3.5A2.2 2.2 0 1 1 5.2 8a2.2 2.2 0 0 1 0-4.5zM3.4 9.5h3.6V21H3.4zM9.3 9.5h3.4v1.6h.1a3.8 3.8 0 0 1 3.4-1.9c3.6 0 4.3 2.3 4.3 5.3V21h-3.6v-5.8c0-1.4 0-3.2-2-3.2s-2.3 1.5-2.3 3.1V21H9.3z"/></svg>
            </a>
            <a href="#" data-social-link="TikTok" aria-label="BlueeWork on TikTok" title="TikTok profile URL to be added">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19.6 7.4a6.6 6.6 0 0 1-4-1.3v8.1a5.7 5.7 0 1 1-5.7-5.7c.4 0 .8 0 1.2.1v3.2a2.6 2.6 0 1 0 1.8 2.5V2.5h3.1c.2 2.2 1.7 4 3.9 4.4v.5h-.3z"/></svg>
            </a>
            <a href="#" data-social-link="YouTube" aria-label="BlueeWork on YouTube" title="YouTube channel URL to be added">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23.2 7a3 3 0 0 0-2.1-2.1C19.3 4.4 12 4.4 12 4.4s-7.3 0-9.1.5A3 3 0 0 0 .8 7 31 31 0 0 0 .3 12c0 1.7.1 3.4.5 5a3 3 0 0 0 2.1 2.1c1.8.5 9.1.5 9.1.5s7.3 0 9.1-.5a3 3 0 0 0 2.1-2.1c.4-1.6.5-3.3.5-5s-.1-3.4-.5-5zM9.7 15.7V8.3l6.2 3.7-6.2 3.7z"/></svg>
            </a>
          </div>
          <p style="font-size:.76rem;margin-top:10px">Official social profile links can be connected before launch.</p>
        </div>
        <div><h4>Get started</h4><a href="#candidates">For candidates</a><a href="#employers">For employers</a><a href="#partners">For partners</a></div>
        <div><h4>Platform</h4><a href="#trades">Worker categories</a><a href="#how-it-works">How it works</a><a href="#" data-open="partnerDialog">Partner onboarding</a><a href="#" data-open="employerDialog">Manpower requisition</a></div>
        <div><h4>Contact</h4><a href="mailto:hello@blueework.com">hello@blueework.com</a><a href="#" data-open="partnerDialog">Partner enquiries</a></div>
        <div>
          <h4>Legal entities</h4>
          <div class="legal-entity">
            <strong>RB Premiere Capital Holding, SIA</strong>
            <span>Registration no. 40103971620</span>
            <span>Riga, Saulgožu iela 4 - 17, LV-1055, Latvia</span>
          </div>
          <div class="legal-entity">
            <strong>MB Ethos 24</strong>
            <span>Registration no. 306713846</span>
            <span>Žirmūnų g. 57, Vilnius, 09110 Vilniaus m. sav., Lithuania</span>
          </div>
        </div>
      </div>
      <div class="copyright">
        <span>© <span id="year"></span> BlueeWork. All rights reserved.</span>
        <span>Privacy · Terms · Data protection policies should be added before launch.</span>
      </div>
    </div>
  </footer>

  <!-- Candidate registration -->
  <dialog id="candidateDialog">
    <div class="dialog-head"><div><h2>Candidate registration</h2><p>Register as a skilled-worker job seeker with BlueeWork.</p></div><button class="close" aria-label="Close" data-close>×</button></div>
    <div class="dialog-body"><form id="candidateForm" method="post" action="submit.php" enctype="multipart/form-data" data-php-submit="true">
      <input type="hidden" name="form_type" value="candidate" />
      <input type="hidden" name="csrf_token" value="<?= $blueeworkCsrf ?>" />
      <div class="honeypot" aria-hidden="true"><label>Leave this field empty<input type="text" name="website_address" tabindex="-1" autocomplete="off" /></label></div>
      <div class="form-section-title">A. Personal and Contact Information</div>
      <div class="form-grid">
        <div class="field"><label for="cName">Full name (as shown on CV) *</label><input id="cName" name="name" required autocomplete="name" /></div>
        <div class="field"><label for="cEmail">Email address *</label><input id="cEmail" name="email" type="email" required autocomplete="email" /></div>
        <div class="field"><label for="cPhone">Phone number (include country code) *</label><input id="cPhone" name="phone" required autocomplete="tel" placeholder="e.g. +370 600 00000" /></div>
        <div class="field"><label for="cCountry">Current country of residence *</label><input id="cCountry" name="country" required autocomplete="country-name" /></div>
        <div class="field"><label for="cCity">City / region</label><input id="cCity" name="city" autocomplete="address-level2" /></div>
        <div class="field"><label for="cNationality">Nationality (optional where appropriate)</label><input id="cNationality" name="nationality" autocomplete="off" /></div>
        <div class="field full"><label for="cEducation">Highest education / qualification</label><input id="cEducation" name="education" placeholder="e.g. vocational qualification, diploma, certificate" /></div>
      </div>

      <div class="form-section-title" style="margin-top:24px">C. CV and Supporting Documents</div>
      <div class="form-grid">
        <div class="field full"><label for="cCv">CV / résumé (PDF or DOCX)</label><input id="cCv" name="cv" type="file" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" /></div>
        <div class="field full"><label for="cCertificates">Certificates or qualifications relevant to the role (optional)</label><input id="cCertificates" name="certificates[]" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,application/pdf" multiple /></div>
        <div class="field full"><label for="cProfile">Portfolio or professional profile link (optional)</label><input id="cProfile" name="profile" type="url" placeholder="https://" /></div>
      </div>
      <p class="small-help">For the live website, files should be collected through secure upload rather than ordinary email. Avoid collecting passport, identity, or other sensitive documents at initial registration unless necessary and legally justified.</p>

      <div class="form-section-title" style="margin-top:24px">D. Candidate Declaration and Consent</div>
      <div class="form-grid">
        <div class="field full"><label class="consent-label"><input type="checkbox" name="accuracyConsent" required /> I confirm that the information I have provided is accurate to the best of my knowledge.</label></div>
        <div class="field full"><label class="consent-label"><input type="checkbox" name="privacyConsent" required /> I have read the privacy notice and consent to the use of my information for recruitment and job-matching purposes.</label></div>
        <div class="field full"><label class="consent-label"><input type="checkbox" name="jobUpdates" /> Optional: I would like to receive relevant job opportunity updates.</label></div>
      </div>
      <div class="form-note">Your registration and selected files will be processed by BlueeWork for recruitment and job-matching purposes. The form data will be saved securely and a spreadsheet notification will be sent to the BlueeWork team. Please do not upload passport or identity documents at this stage unless specifically requested through an approved secure process.</div>
      <div class="form-actions"><button type="button" class="btn btn-outline" data-close>Cancel</button><button class="btn btn-primary" type="submit">Submit candidate registration</button></div><div class="success" role="status"></div>
    </form></div>
  </dialog>

  <!-- Employer requisition -->
  <dialog id="employerDialog">
    <div class="dialog-head"><div><h2>Manpower requisition</h2><p>Describe the workers your company needs.</p></div><button class="close" aria-label="Close" data-close>×</button></div>
    <div class="dialog-body"><form id="employerForm" method="post" action="submit.php" enctype="multipart/form-data" data-php-submit="true">
      <input type="hidden" name="form_type" value="company" />
      <input type="hidden" name="csrf_token" value="<?= $blueeworkCsrf ?>" />
      <div class="honeypot" aria-hidden="true"><label>Leave this field empty<input type="text" name="website_address" tabindex="-1" autocomplete="off" /></label></div>
      <div class="form-grid">
        <div class="field"><label for="eCompany">Company legal name *</label><input id="eCompany" name="company" required /></div>
        <div class="field"><label for="eWebsite">Company website</label><input id="eWebsite" name="website" type="url" placeholder="https://" /></div>
        <div class="field"><label for="eIndustry">Industry / business sector *</label><input id="eIndustry" name="industry" required placeholder="e.g. construction, manufacturing" /></div>
        <div class="field"><label for="eReg">Company registration number</label><input id="eReg" name="registrationNumber" /></div>
        <div class="field"><label for="eContact">Contact person *</label><input id="eContact" name="contact" required /></div>
        <div class="field"><label for="eEmail">Business email *</label><input id="eEmail" name="email" type="email" required /></div>
        <div class="field"><label for="ePhone">Phone *</label><input id="ePhone" name="phone" required /></div>
        <div class="field"><label for="eCountry">Work country / location *</label><input id="eCountry" name="location" required /></div>
        <div class="field"><label for="eStart">Expected start date</label><input id="eStart" name="startDate" type="date" /></div>
        <div class="field full">
          <div class="form-section-title">Roles / skilled-worker categories required *</div>
          <p class="small-help">Add one row for each trade or role. Enter the number of workers and the required skill level for each.</p>
          <div id="roleRows">
            <div class="role-row">
              <div class="field"><label for="roleCategory0">Trade / category *</label><select id="roleCategory0" name="roles[0][category]" required><option value="">Choose a category</option><option>Electricians</option><option>Industrial electricians</option><option>Welders</option><option>Pipe welders</option><option>Fabricators</option><option>Plumbers</option><option>Pipefitters</option><option>HVAC technicians</option><option>Refrigeration technicians</option><option>Solar panel installers</option><option>Carpenters</option><option>Joiners</option><option>Formwork carpenters</option><option>Steel fixers / rebar workers</option><option>Masons / bricklayers</option><option>Concrete workers</option><option>Plasterers</option><option>Painters</option><option>Tilers</option><option>Roofers</option><option>Glaziers</option><option>Drywall installers</option><option>Insulation installers</option><option>Scaffolders</option><option>Crane operators</option><option>Forklift operators</option><option>Excavator operators</option><option>Heavy equipment operators</option><option>Truck drivers</option><option>Bus drivers</option><option>Automotive mechanics</option><option>Diesel mechanics</option><option>Industrial mechanics</option><option>Maintenance technicians</option><option>CNC machine operators</option><option>Machine operators</option><option>Production line operators</option><option>Quality control inspectors</option><option>Industrial cleaners</option><option>Warehouse workers</option><option>Logistics / material handlers</option><option>Rigging and lifting technicians</option><option>Shipyard workers</option><option>Oil and gas technicians</option><option>Mining technicians</option><option>Food production workers</option><option>Butchers / meat processors</option><option>Bakers</option><option>Landscaping / grounds workers</option><option>Agricultural workers</option><option>Other / not listed</option></select></div>
              <div class="field"><label for="roleCount0">Workers *</label><input id="roleCount0" name="roles[0][count]" type="number" min="1" max="100000" required placeholder="e.g. 25" /></div>
              <div class="field"><label for="roleLevel0">Skill level *</label><select id="roleLevel0" name="roles[0][skillLevel]" required><option value="">Choose</option><option>Entry level</option><option>Skilled</option><option>Highly skilled / specialist</option><option>Supervisor / foreman</option></select></div>
              <button type="button" class="role-remove" aria-label="Remove this role" title="Remove this role" disabled>×</button>
            </div>
          </div>
          <button type="button" class="btn btn-outline" id="addRole">＋ Add another role / trade</button>
        </div>
        <div class="field"><label for="eExperience">Minimum experience</label><select id="eExperience" name="experience"><option>Not specified</option><option>Entry level</option><option>1–3 years</option><option>4–7 years</option><option>8+ years</option></select></div>
        <div class="field"><label for="eEducation">Education / certifications</label><input id="eEducation" name="education" placeholder="Required qualifications or licences" /></div>
        <div class="field"><label for="eLanguages">Languages required</label><input id="eLanguages" name="languages" placeholder="e.g. English, German" /></div>
        <div class="field"><label for="eDuration">Contract duration</label><select id="eDuration" name="duration"><option>Not specified</option><option>Less than 6 months</option><option>6–12 months</option><option>1–2 years</option><option>Permanent</option></select></div>
        <div class="field"><label for="eHours">Working hours / shifts</label><input id="eHours" name="hours" placeholder="e.g. 40 hours/week, shifts" /></div>
        <div class="field"><label for="eDeadline">Application deadline</label><input id="eDeadline" name="deadline" type="date" /></div>
        <div class="field"><label for="eSalary">Salary / pay range</label><input id="eSalary" name="salary" placeholder="Amount, currency and pay period" /></div>
        <div class="field full"><label for="eSkills">Required skills, certifications and job details *</label><textarea id="eSkills" name="skills" required placeholder="Describe duties, skill level, certifications, working hours and any other requirements."></textarea></div>
        <div class="field full"><label for="eBenefits">Benefits / accommodation / transport</label><textarea id="eBenefits" name="benefits" placeholder="Describe benefits and what the employer provides."></textarea></div>
        <div class="field full"><label>Work permit / visa support</label><div class="checks"><label><input type="radio" name="visaSupport" value="Employer sponsorship available" /> Employer sponsorship available</label><label><input type="radio" name="visaSupport" value="Candidate must already be authorized" /> Candidate must already be authorized</label><label><input type="radio" name="visaSupport" value="Support required" /> Support required</label><label><input type="radio" name="visaSupport" value="To be discussed" /> To be discussed</label></div></div>
        <div class="field full"><label><input type="checkbox" name="employerConsent" value="1" required /> I am authorised to submit this request on behalf of the company and agree to be contacted about it.</label></div>
        <div class="field full"><label><input type="checkbox" name="companyPrivacyConsent" value="1" required /> I have read the applicable BlueeWork privacy notice and understand how this hiring request will be processed.</label></div>
      </div>
      <div class="form-note">Your company details and requested roles will be saved securely, and a spreadsheet notification will be sent to the BlueeWork team. Submission does not itself create a contract or guarantee candidate availability.</div>
      <div class="form-actions"><button type="button" class="btn btn-outline" data-close>Cancel</button><button class="btn btn-primary" type="submit">Submit requisition</button></div><div class="success" role="status"></div>
    </form></div>
  </dialog>

  <!-- Partner KYC -->
  <dialog id="partnerDialog">
    <div class="dialog-head"><div><h2>Recruitment partner onboarding</h2><p>Apply to join the BlueeWork partner network.</p></div><button class="close" aria-label="Close" data-close>×</button></div>
    <div class="dialog-body"><form id="partnerForm" method="post" action="submit.php" enctype="multipart/form-data" data-php-submit="true">
      <input type="hidden" name="form_type" value="partner" />
      <input type="hidden" name="csrf_token" value="<?= $blueeworkCsrf ?>" />
      <div class="honeypot" aria-hidden="true"><label>Leave this field empty<input type="text" name="website_address" tabindex="-1" autocomplete="off" /></label></div>
      <div class="form-grid">
        <div class="field"><label for="pLegal">Registered legal company name *</label><input id="pLegal" name="legalName" required /></div>
        <div class="field"><label for="pBrand">Trading name (if different)</label><input id="pBrand" name="tradingName" /></div>
        <div class="field"><label for="pBusinessType">Business type *</label><select id="pBusinessType" name="businessType" required><option value="">Choose type</option><option>Recruitment agency</option><option>Staffing company</option><option>Manpower agency</option><option>Independent recruitment consultant</option><option>Other</option></select></div>
        <div class="field"><label for="pEstablished">Year established</label><input id="pEstablished" name="yearEstablished" type="number" min="1800" max="2100" placeholder="e.g. 2015" /></div>
        <div class="field"><label for="pCountry">Country of registration *</label><select id="pCountry" name="country" required><option value="">Select region / country</option><optgroup label="South Asia"><option>Bangladesh</option><option>India</option><option>Nepal</option><option>Pakistan</option><option>Sri Lanka</option><option>Other South Asian country</option></optgroup><optgroup label="Middle East"><option>United Arab Emirates</option><option>Saudi Arabia</option><option>Qatar</option><option>Oman</option><option>Kuwait</option><option>Bahrain</option><option>Other Middle Eastern country</option></optgroup><optgroup label="Europe"><option>Lithuania</option><option>Poland</option><option>Germany</option><option>Romania</option><option>Other European country</option></optgroup><option>Other</option></select></div>
        <div class="field"><label for="pReg">Company registration number *</label><input id="pReg" name="registrationNumber" required /></div>
        <div class="field"><label for="pAddress">Registered business address *</label><input id="pAddress" name="address" required /></div>
        <div class="field"><label for="pWebsite">Company website</label><input id="pWebsite" name="website" type="url" placeholder="https://" /></div>
        <div class="field full"><label for="pLogo">Agency logo * (PNG, JPG or WebP; up to 2 MB)</label>
          <div class="partner-logo-upload">
            <input id="pLogo" name="agencyLogo" type="file" accept="image/png,image/jpeg,image/webp" required aria-describedby="pLogoHelp" />
            <p id="pLogoHelp" class="small-help">Upload the logo you authorize BlueeWork to display on the website if your agency is approved.</p>
            <div class="partner-logo-preview-wrap"><img id="partnerLogoPreview" alt="Preview of agency logo" /><span class="partner-logo-preview-text" id="partnerLogoPreviewText">Your logo preview will appear here.</span></div>
          </div>
        </div>

        <div class="field"><label for="pRep">Authorised representative *</label><input id="pRep" name="representative" required /></div>
        <div class="field"><label for="pRole">Representative's role *</label><input id="pRole" name="role" required placeholder="e.g. Director" /></div>
        <div class="field"><label for="pEmail">Business email *</label><input id="pEmail" name="email" type="email" required /></div>
        <div class="field"><label for="pPhone">Business phone *</label><input id="pPhone" name="phone" required /></div>
        <div class="field full"><label>Recruitment licence status *</label><div class="checks"><label><input type="radio" name="licence" value="Licensed" required /> Licensed</label><label><input type="radio" name="licence" value="Not required in my jurisdiction" /> Not required in my jurisdiction</label><label><input type="radio" name="licence" value="Pending" /> Application pending</label></div></div>
        <div class="field"><label for="pLicenceNo">Licence number (if applicable)</label><input id="pLicenceNo" name="licenceNumber" /></div>
        <div class="field"><label for="pYears">Years in recruitment</label><select id="pYears" name="years"><option>Choose</option><option>Less than 1 year</option><option>1–3 years</option><option>4–7 years</option><option>8–15 years</option><option>15+ years</option></select></div>
        <div class="field full"><label for="pSourceCountries">Countries where candidates are sourced *</label><input id="pSourceCountries" name="sourceCountries" required placeholder="List source countries" /></div>
        <div class="field full"><label for="pMarkets">Countries / markets served</label><input id="pMarkets" name="marketsServed" placeholder="List destination countries or markets" /></div>
        <div class="field full"><label for="pTrades">Industries and job categories covered *</label><textarea id="pTrades" name="trades" required placeholder="e.g. welding, electrical, construction, manufacturing, logistics"></textarea></div>
        <div class="field full"><label for="pProfiles">Typical candidate profiles</label><textarea id="pProfiles" name="candidateProfiles" placeholder="Common trades, qualifications and experience levels"></textarea></div>
        <div class="field"><label for="pCapacity">Approximate candidates available per month</label><input id="pCapacity" name="capacity" type="number" min="0" placeholder="e.g. 50" /></div>
        <div class="field"><label for="pClientSectors">Employer network / client sectors</label><input id="pClientSectors" name="clientSectors" placeholder="e.g. construction, shipbuilding" /></div>
        <div class="field full"><label for="pModel">Recruitment experience and proposed partnership model</label><textarea id="pModel" name="partnershipModel" placeholder="Describe experience, delivery model and collaboration preferences"></textarea></div>
        <div class="field full"><label for="pDocuments">Supporting documents (optional in this prototype)</label>
          <input id="pDocuments" name="supportingDocuments[]" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple />
          <p class="small-help">Where applicable: company registration certificate, recruitment licence / authorisation, company profile or capability statement, and signed partnership agreement. Files selected here are not uploaded or saved in this demo.</p>
        </div>
        <div class="field full"><label for="pOwners">Directors / beneficial owners (names and roles) *</label><textarea id="pOwners" name="owners" required placeholder="Provide names and roles here. Identity documents should be collected only through a secure, access-controlled upload process."></textarea></div>
        <div class="field full"><label for="pCompliance">Compliance declarations *</label><div class="checks"><label><input type="checkbox" name="companyInformationAccurate" value="1" required /> Company information is accurate</label><label><input type="checkbox" name="legalComplianceConsent" value="1" required /> We will comply with applicable recruitment and labour laws</label><label><input type="checkbox" name="dueDiligenceConsent" value="1" required /> We consent to partner due diligence and verification</label><label><input type="checkbox" name="logoDisplayConsent" value="1" required /> We authorize BlueeWork to display our agency logo if our agency is approved</label><label><input type="checkbox" name="partnerPrivacyConsent" value="1" required /> We have read the applicable BlueeWork privacy notice and understand this application may be reviewed and verified.</label></div></div>
      </div>
      <div class="form-note"><strong>KYC and privacy:</strong> Your application, logo and supporting documents will be stored in a restricted area and a spreadsheet notification will be emailed to BlueeWork. Your logo will not be displayed publicly unless the agency is verified and approved. Do not upload identity documents unless specifically requested through an approved secure process.</div>
      <div class="form-actions"><button type="button" class="btn btn-outline" data-close>Cancel</button><button class="btn btn-primary" type="submit">Submit partner application</button></div><div class="success" role="status"></div>
    </form></div>
  </dialog>

  <script>

    // BlueeWork matching platform concept preview. Illustrative sample data only.
    const matchExamples = [
      {company:'NordBuild Construction',logo:'N',title:'Skilled Welder',location:'Vilnius, Lithuania',contract:'Full-time',exp:'3+ years',pay:'€2,400–3,000',fit:'94%',tag:'SKILLS MATCH',count:'4 related skills',skills:['MIG / TIG welding','Technical drawings','Site safety']},
      {company:'Baltic Technical Group',logo:'B',title:'Industrial Electrician',location:'Riga, Latvia',contract:'Full-time',exp:'2+ years',pay:'€2,100–2,700',fit:'89%',tag:'POTENTIAL MATCH',count:'3 related skills',skills:['Electrical maintenance','Fault finding','Safety procedures']},
      {company:'NorthWorks Projects',logo:'W',title:'Construction Carpenter',location:'Kaunas, Lithuania',contract:'Project contract',exp:'3+ years',pay:'€2,000–2,600',fit:'86%',tag:'SKILLS MATCH',count:'3 related skills',skills:['Carpentry','Technical plans','Site safety']}
    ];
    let matchExampleIndex = 0;
    const matchExample = id => document.getElementById(id);
    function renderMatchExample(){
      const j = matchExamples[matchExampleIndex % matchExamples.length];
      if (!matchExample('matchTitle')) return;
      matchExample('matchCompany').textContent = j.company;
      matchExample('matchCompanyLogo').textContent = j.logo;
      matchExample('matchTitle').textContent = j.title;
      matchExample('matchLocation').textContent = '📍 ' + j.location;
      matchExample('matchContract').textContent = j.contract;
      matchExample('matchExperience').textContent = j.exp;
      matchExample('matchPay').innerHTML = j.pay + ' <small>/ month gross*</small>';
      matchExample('matchFit').textContent = j.fit + ' match';
      matchExample('matchJobTag').textContent = j.tag;
      matchExample('matchSkillCount').textContent = j.count;
      matchExample('matchSkillChips').replaceChildren(...j.skills.map(skill => { const span=document.createElement('span'); span.textContent=skill; return span; }));
      const card=matchExample('matchJobCard'); card.style.opacity='1'; card.style.transform='translateY(0)';
    }
    function advanceMatchExample(action){
      const card=matchExample('matchJobCard');
      const actionText={pass:'Passed on this illustrative role. Another example is shown.',like:'Interest noted in this demo. No employer was contacted.',save:'Example role saved for this preview only.',details:'Match explanation: the example score represents overlap between the sample skills shown and an illustrative job requirement.'};
      if (action==='details'){matchExample('matchActionHint').textContent=actionText.details;return;}
      card.style.opacity='.25'; card.style.transform=action==='like'?'translateX(24px) rotate(2deg)':'translateX(-24px) rotate(-2deg)';
      window.setTimeout(()=>{matchExampleIndex++;renderMatchExample();matchExample('matchActionHint').textContent=actionText[action]||'Showing the next sample role.';},170);
    }
    if(matchExample('matchPass')) matchExample('matchPass').addEventListener('click',()=>advanceMatchExample('pass'));
    if(matchExample('matchLike')) matchExample('matchLike').addEventListener('click',()=>advanceMatchExample('like'));
    if(matchExample('matchSave')) matchExample('matchSave').addEventListener('click',()=>advanceMatchExample('save'));
    if(matchExample('matchDetails')) matchExample('matchDetails').addEventListener('click',()=>advanceMatchExample('details'));
    renderMatchExample();



    // Employer requisitions can include several trades, each with its own headcount and skill level.
    const roleRows = document.getElementById('roleRows');
    const addRoleButton = document.getElementById('addRole');
    const tradeOptionMarkup = `<option>Electricians</option><option>Industrial electricians</option><option>Welders</option><option>Pipe welders</option><option>Fabricators</option><option>Plumbers</option><option>Pipefitters</option><option>HVAC technicians</option><option>Refrigeration technicians</option><option>Solar panel installers</option><option>Carpenters</option><option>Joiners</option><option>Formwork carpenters</option><option>Steel fixers / rebar workers</option><option>Masons / bricklayers</option><option>Concrete workers</option><option>Plasterers</option><option>Painters</option><option>Tilers</option><option>Roofers</option><option>Glaziers</option><option>Drywall installers</option><option>Insulation installers</option><option>Scaffolders</option><option>Crane operators</option><option>Forklift operators</option><option>Excavator operators</option><option>Heavy equipment operators</option><option>Truck drivers</option><option>Bus drivers</option><option>Automotive mechanics</option><option>Diesel mechanics</option><option>Industrial mechanics</option><option>Maintenance technicians</option><option>CNC machine operators</option><option>Machine operators</option><option>Production line operators</option><option>Quality control inspectors</option><option>Industrial cleaners</option><option>Warehouse workers</option><option>Logistics / material handlers</option><option>Rigging and lifting technicians</option><option>Shipyard workers</option><option>Oil and gas technicians</option><option>Mining technicians</option><option>Food production workers</option><option>Butchers / meat processors</option><option>Bakers</option><option>Landscaping / grounds workers</option><option>Agricultural workers</option><option>Other / not listed</option>`;
    let roleIndex = 1;
    function updateRoleRows() {
      const rows = [...roleRows.querySelectorAll('.role-row')];
      rows.forEach((row, idx) => {
        const remove = row.querySelector('.role-remove');
        remove.disabled = rows.length === 1;
        remove.onclick = () => {
          if (roleRows.querySelectorAll('.role-row').length > 1) {
            row.remove();
            updateRoleRows();
          }
        };
      });
    }
    if (roleRows && addRoleButton) {
      addRoleButton.addEventListener('click', () => {
        const idx = roleIndex++;
        const row = document.createElement('div');
        row.className = 'role-row';
        row.innerHTML = `
          <div class="field"><label for="roleCategory${idx}">Trade / category *</label><select id="roleCategory${idx}" name="roles[${idx}][category]" required><option value="">Choose a category</option>${tradeOptionMarkup}</select></div>
          <div class="field"><label for="roleCount${idx}">Workers *</label><input id="roleCount${idx}" name="roles[${idx}][count]" type="number" min="1" max="100000" required placeholder="e.g. 25" /></div>
          <div class="field"><label for="roleLevel${idx}">Skill level *</label><select id="roleLevel${idx}" name="roles[${idx}][skillLevel]" required><option value="">Choose</option><option>Entry level</option><option>Skilled</option><option>Highly skilled / specialist</option><option>Supervisor / foreman</option></select></div>
          <button type="button" class="role-remove" aria-label="Remove this role" title="Remove this role">×</button>`;
        roleRows.appendChild(row);
        updateRoleRows();
        row.querySelector('select').focus();
      });
      updateRoleRows();
    }


    // Agency logo preview: local browser preview only; it is not uploaded or published.
    const partnerLogoInput = document.getElementById('pLogo');
    const partnerLogoPreview = document.getElementById('partnerLogoPreview');
    const partnerLogoPreviewText = document.getElementById('partnerLogoPreviewText');
    let partnerLogoObjectUrl = null;
    if (partnerLogoInput && partnerLogoPreview) {
      partnerLogoInput.addEventListener('change', () => {
        const file = partnerLogoInput.files && partnerLogoInput.files[0];
        if (partnerLogoObjectUrl) {
          URL.revokeObjectURL(partnerLogoObjectUrl);
          partnerLogoObjectUrl = null;
        }
        partnerLogoPreview.classList.remove('visible');
        partnerLogoPreview.removeAttribute('src');
        if (!file) {
          partnerLogoPreviewText.textContent = 'Your logo preview will appear here.';
          return;
        }
        const allowed = ['image/png', 'image/jpeg', 'image/webp'];
        if (!allowed.includes(file.type)) {
          partnerLogoInput.setCustomValidity('Please choose a PNG, JPG or WebP image.');
          partnerLogoInput.reportValidity();
          partnerLogoInput.value = '';
          partnerLogoInput.setCustomValidity('');
          partnerLogoPreviewText.textContent = 'Please select a PNG, JPG or WebP logo.';
          return;
        }
        if (file.size > 2 * 1024 * 1024) {
          partnerLogoInput.setCustomValidity('Please choose a logo smaller than 2 MB.');
          partnerLogoInput.reportValidity();
          partnerLogoInput.value = '';
          partnerLogoInput.setCustomValidity('');
          partnerLogoPreviewText.textContent = 'The selected file was larger than 2 MB.';
          return;
        }
        partnerLogoObjectUrl = URL.createObjectURL(file);
        partnerLogoPreview.src = partnerLogoObjectUrl;
        partnerLogoPreview.classList.add('visible');
        partnerLogoPreviewText.textContent = file.name + ' — local preview only; final website publication follows approval.';
      });
    }


    document.querySelectorAll('[data-social-link]').forEach(link => {
      link.addEventListener('click', event => {
        event.preventDefault();
        const network = link.dataset.socialLink || 'social media';
        window.alert('Add BlueeWork’s official ' + network + ' profile URL before launch.');
      });
    });

    const dialogs = [...document.querySelectorAll('dialog')];
    document.querySelectorAll('[data-open]').forEach(btn => btn.addEventListener('click', e => {
      e.preventDefault();
      const dialog = document.getElementById(btn.dataset.open);
      if (dialog && !dialog.open) dialog.showModal();
      const mobileNav = document.getElementById('navlinks');
      if (mobileNav) mobileNav.classList.remove('open');
    }));
    document.querySelectorAll('[data-close]').forEach(btn => btn.addEventListener('click', () => btn.closest('dialog').close()));
    dialogs.forEach(dialog => dialog.addEventListener('click', e => {
      if (e.target === dialog) dialog.close();
    }));
    document.querySelectorAll('form').forEach(form => form.addEventListener('submit', e => {
      if (form.dataset.phpSubmit === 'true') return; // Allow normal multipart POST to submit.php.
      e.preventDefault();
      if (!form.reportValidity()) return;
      const success = form.querySelector('.success');
      const messages = {
        candidateForm: 'Your candidate profile form passed local validation. This demo has not sent or saved your details.',
        employerForm: 'Your requisition form passed local validation. This demo has not sent or saved your request.',
        partnerForm: 'Your application passed local validation in this demo. Nothing was sent or saved. On the live platform, your logo will be added to the public partner directory only after BlueeWork verifies and approves your agency.'
      };
      success.textContent = messages[form.id] || 'Form validated. No information was sent.';
      success.classList.add('show');
      success.scrollIntoView({behavior:'smooth',block:'nearest'});
    }));
    const menuToggle = document.getElementById('menuToggle');
    if (menuToggle) menuToggle.addEventListener('click', () => { const nav = document.getElementById('navlinks'); if (nav) nav.classList.toggle('open'); });
    document.querySelectorAll('#navlinks a').forEach(a => a.addEventListener('click', () => { const nav = document.getElementById('navlinks'); if (nav) nav.classList.remove('open'); }));
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>
</body>
</html>