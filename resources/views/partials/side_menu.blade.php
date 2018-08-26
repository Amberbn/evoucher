<div id="side-menu">
        <ul class="nav flex-column">
          
          <li class="nav-item first">
            <div class="admin-bar__main-menu">
              <button class="btn"><span class="lines-menu"></span></button>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link nav-link-dashboard active" href="{{ route('home') }}">
              <span class="nav-link__icon icon-ic_dashboard"><span class="nav-link__text">Dashboard</span></span>
            </a>
          </li>

          @isPermitted('client','read')
          <li class="nav-item">
            <a class="nav-link nav-link-client" href="{{ route('client.index') }}">
              <span class="nav-link__icon icon-ic_client"><span class="nav-link__text">Client</span></span>
            </a>
          </li>
          @endisPermitted

          @isPermitted('campaign','read')
          <li class="nav-item">
            <a class="nav-link nav-link-campaign" href="#">
              <span class="nav-link__icon icon-ic_campaign"><span class="nav-link__text">Campaign</span></span>
            </a>
          </li>
          @endisPermitted

          @isPermitted('voucher','read')
          <li class="nav-item">
            <a class="nav-link nav-link-coupon" href="{{ route('voucher.index') }}">
              <span class="nav-link__icon icon-ic_coupon"><span class="nav-link__text">Coupon</span></span>
            </a>
          </li>
          @endisPermitted

          @isPermitted('merchant','read')
          <li class="nav-item">
            <a class="nav-link nav-link-merchant" href="{{ route('merchant.index') }}">
              <span class="nav-link__icon icon-ic_merchant"><span class="nav-link__text">Merchant</span></span>
            </a>
          </li>
          @endisPermitted

          @isPermitted('invoice','read')
          <li class="nav-item">
            <a class="nav-link nav-link-invoice" href="#">
              <span class="nav-link__icon icon-ic_invoice"><span class="nav-link__text">Invoice</span></span>
            </a>
          </li>
          @endisPermitted

          @isPermitted('deposit','delete')
          <li class="nav-item">
            <a class="nav-link nav-link-deposit" href="#">
              <span class="nav-link__icon icon-ic_deposit"><span class="nav-link__text">Deposit</span></span>
            </a>
          </li>
          @endisPermitted

          @isPermitted('user','delete')
          <li class="nav-item">
            <a class="nav-link nav-link-user" href="{{ route('user.index') }}">
              <span class="nav-link__icon icon-ic_user"><span class="nav-link__text">User</span></span>
            </a>
          </li>
          @endisPermitted

        </ul>
      </div>