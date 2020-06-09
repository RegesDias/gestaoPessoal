
<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
    $mes;

?>         
            <table>
            <caption class="mes">Fevereiro 2011</caption>
            <thead>
                <tr>
                    <td class="dia"><div class="semana">D</td>
                    <td class="dia"><div class="semana">S</td>
                    <td class="dia"><div class="semana">T</td>
                    <td class="dia"><div class="semana">Q</td>
                    <td class="dia"><div class="semana">Q</td>
                    <td class="dia"><div class="semana">S</td>
                    <td class="dia"><div class="semana">S</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="dia">1<span class="evento">2</span></td>
                    <td class="dia">2<span class="evento">5</span></td>
                    <td class="dia">3<span class="evento">3</span></td>
                    <td class="dia">4</td>
                    <td class="dia">5<span class="evento">1</span></td>
                    <td class="dia">6</td>
                    <td class="dia">7</td>
                </tr>
                <tr>
                    <td class="dia">8<span class="evento">2</span></td>
                    <td class="dia">9</td>
                    <td class="dia">10</td>
                    <td class="dia">11<span class="evento">5</span></td>
                    <td class="dia">12</td>
                    <td class="dia">13<span class="evento"></span></td>
                    <td class="dia">14</td>
                </tr>           
                <tr>
                    <td class="dia">15<span class="evento">2</span></td>
                    <td class="dia">16</td>
                    <td class="dia">17</td>
                    <td class="dia">18<span class="evento">5</span></td>
                    <td class="dia">19</td>
                    <td class="dia">20<span class="evento"></span></td>
                    <td class="dia">21</td>
                </tr>
                <tr>
                    <td class="dia">22<span class="evento">2</span></td>
                    <td class="dia">23</td>
                    <td class="dia">24</td>
                    <td class="dia">25<span class="evento">5</span></td>
                    <td class="dia">26</td>
                    <td class="dia">27<span class="evento"></span></td>
                    <td class="dia">28</td>
                </tr>
            </tbody>
        </table>

        <style>
            .mes {
                font: bold 12px verdana;
                background: #f5f5f5;
                text-align: center;
                line-height: 25px;               
                height: 35px;
                width: 280px;
            }
            .semana {
                font: bold 12px verdana;
                background: #f5f5f5;
                text-align: center;
                line-height: 25px;                           
                height: 35px;
                width: 40px;
            }
            .dia {
                background: #f5f5f5;
                font: 12px verdana;                   
                text-align: center;
                height: 35px;
                width: 40px;
            }
            .evento {
                position: relative;
                font: 9px verdana;
                color: #C30;
                right: -7px;
                top: -9px;     
        </style>